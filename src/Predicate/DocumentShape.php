<?php

namespace Slendium\Ocd\Predicate;

use Closure;

use Slendium\Ocd\Predicate;
use Slendium\Ocd\Schema\StorageClass;

/**
 * Utility methods for building "document shape" predicates.
 *
 * A document shape in SQL is essentially a `WHERE` clause specifying multiple fields and the patterns
 * they must match for a row to be included in the results.
 * For example: `WHERE category = :category AND stock > 0 AND visible = 1 AND...` would be created as follows:
 *
 * ```php
 * use Slendium\Ocd\Predicate\DocumentShape as Q;
 *
 * $query = Q::shape([
 * 	'name' => Q::regex('^pen'),
 * 	'category' => 'OfficeSupplies',
 * 	'stock' => Q::gt(0),
 * 	'visible' => true,
 * 	'stores' => Q::isNonEmpty(),
 * 	'details' => Q::and([
 * 		'tags' => Q::matchSome([ 'either', 'this', 'or', 'that' ]),
 * 		'review' => Q::path([ 'score', 'average' ], Q::gte(0.75))
 * 	])
 * ]);
 * ```
 *
 * It is also possible to directly compare different fields in the same document:
 *
 * ```php
 * use Slendium\Ocd\Predicate\DocumentShape as Q;
 *
 * $query = Q::shape([
 * 	'name' => Q::field([ 'nested', 'field' ]),
 * 	'count' => Q::lt(Q::field('limit'))
 * ]);
 * ```
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DocumentShape {

	/**
	 * @since 1.0
	 * @param non-empty-array<non-empty-string,(Closure(FieldPath):Predicate)|string|float|int|bool|null> $shape
	 */
	public static function shape(array $shape): Expr\And_ {
		$inputs = [ ];
		foreach ($shape as $field => $spec) {
			$inputs[] = $spec instanceof Closure
				? $spec(self::field((string)$field))
				: new Expr\Equal(self::field((string)$field), $spec);
		}
		return new Expr\And_($inputs);
	}

	/**
	 * @since 1.0
	 * @param non-empty-array<non-empty-string,(Closure(FieldPath):Predicate)|string|float|int|bool|null> $shape
	 * @return Closure(FieldPath):Expr\And_
	 */
	public static function and(array $shape): Closure {
		return static fn(FieldPath $basePath) => new Expr\And_(self::resolveInnerShape($basePath, $shape));
	}

	/**
	 * @since 1.0
	 * @param non-empty-array<non-empty-string,(Closure(FieldPath):Predicate)|string|float|int|bool|null> $shape
	 * @return Closure(FieldPath):Expr\Or_
	 */
	public static function or(array $shape): Closure {
		return static fn(FieldPath $basePath) => new Expr\Or_(self::resolveInnerShape($basePath, $shape));
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\Equal
	 */
	public static function eq(string|float|int|bool|null $rhs): Closure {
		return static fn(FieldPath $field) => new Expr\Equal($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\NotEqual
	 */
	public static function notEqual(string|float|int|bool|null $rhs): Closure {
		return static fn(FieldPath $field) => new Expr\NotEqual($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\GreaterThan
	 */
	public static function gt(FieldPath|float|int $rhs): Closure {
		return static fn(FieldPath $field) => new Expr\GreaterThan($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\GreaterThanOrEqual
	 */
	public static function gte(FieldPath|float|int $rhs): Closure {
		return static fn(FieldPath $field) => new Expr\GreaterThanOrEqual($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\LessThan
	 */
	public static function lt(FieldPath|float|int $rhs): Closure {
		return static fn(FieldPath $field) => new Expr\LessThan($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\LessThanOrEqual
	 */
	public static function lte(FieldPath|float|int $rhs): Closure {
		return static fn(FieldPath $field) => new Expr\LessThanOrEqual($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<string|float|int|bool|null> $values
	 * @return Closure(FieldPath):Expr\MatchAll
	 */
	public static function matchAll(array $values): Closure {
		return static fn(FieldPath $field) => new Expr\MatchAll($field, $values);
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<string|float|int|bool|null> $values
	 * @return Closure(FieldPath):Expr\MatchSome
	 */
	public static function matchSome(array $values): Closure {
		return static fn(FieldPath $field) => new Expr\MatchSome($field, $values);
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<string|float|int|bool|null> $values
	 * @return Closure(FieldPath):Expr\MatchNone
	 */
	public static function matchNone(array $values): Closure {
		return static fn(FieldPath $field) => new Expr\MatchNone($field, $values);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\MatchRegex
	 */
	public static function regex(string $regex): Closure {
		return static fn(FieldPath $field) => new Expr\MatchRegex($field, $regex);
	}

	/**
	 * Matches a field that has an empty value.
	 *
	 * A field is considered empty when either:
	 *
	 * * The field does not exist
	 * * The field is `null`
	 * * The field is an empty string
	 *
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\Or_
	 */
	public static function isEmpty(): Closure {
		return static fn(FieldPath $field) => new Expr\Or_([
			new Expr\NotExists($field),
			new Expr\MatchSome($field, [ null, '' ])
		]);
	}

	/**
	 * @since 1.0
	 * @see ::isEmpty() For a description of when a field is considered empty
	 * @return Closure(FieldPath):Expr\And_
	 */
	public static function isNonEmpty(): Closure {
		return static fn(FieldPath $field) => new Expr\And_([
			new Expr\Exists($field),
			new Expr\MatchNone($field, [ null, '' ])
		]);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\IsOfType
	 */
	public static function isOfType(StorageClass $type): Closure {
		return static fn(FieldPath $field) => new Expr\IsOfType($field, $type);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):Expr\NotOfType
	 */
	public static function isNotOfType(StorageClass $type): Closure {
		return static fn(FieldPath $field) => new Expr\NotOfType($field, $type);
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<non-empty-string> $path
	 * @param Closure(FieldPath):Predicate $wrappee
	 * @return Closure(FieldPath):Predicate
	 */
	public static function path(array $path, Closure $wrappee): Closure {
		return static fn(FieldPath $base) => $wrappee(new FieldPath([ ...$base->path, ...$path ]));
	}

	/**
	 * Shorthand for normalizing fields to a {@see FieldPath} instance.
	 * @since 1.0
	 * @param FieldPath|non-empty-list<non-empty-string>|non-empty-string $field
	 */
	public static function field(FieldPath|array|string $field): FieldPath {
		if (\is_string($field)) {
			$field = [ $field ];
		}

		return \is_array($field)
			? new FieldPath($field)
			: $field;
	}

	/**
	 * @param non-empty-array<non-empty-string,(Closure(FieldPath):Predicate)|string|float|int|bool|null> $shape
	 * @return non-empty-list<Predicate>
	 */
	private static function resolveInnerShape(FieldPath $basePath, array $shape): array {
		$out = [ ];
		foreach ($shape as $field => $spec) {
			$fullPath = new FieldPath([ ...$basePath->path, $field ]);
			$out[] = $spec instanceof Closure
				? $spec($fullPath)
				: new Expr\Equal($fullPath, $spec);
		}
		return $out;
	}

	private function __construct() { }

}
