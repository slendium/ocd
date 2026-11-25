<?php

namespace Slendium\Ocd\Query;

use BackedEnum;
use Closure;
use DateTimeInterface;
use LogicException;

use Slendium\Ocd\Entity;

/**
 * Utility methods for building "shape" predicates.
 *
 * A document shape in SQL is essentially a `WHERE` clause specifying multiple fields and the patterns
 * they must match for a row to be included in the results.
 *
 * ## Examples
 *
 * ### Equality
 *
 * Match documents where the given fields must be equal or not equal to the given values:
 *
 * ```php
 * use Slendium\Ocd\Query\DocumentShape as Q;
 *
 * $where = Q::create([
 * 	'category' => 'OfficeSuplies',
 * 	'stock' => 10,
 * 	'published' => new DateTime,
 * 	'visible' => Q::neq(false) // neq = not equal
 * ]);
 * ```
 *
 * ### Comparisons
 *
 * Match documents where the given fields must have values relative to the given values:
 *
 * ```php
 * $where = Q::create([
 * 	'stock' => Q::gt(0), // greater than
 * 	'rating' => Q::gte(0.8), // greater than or equal
 * 		// Q::lt() = less than, Q::lte() = less than or equal
 * 	'published' => Q::onOrAfter(new DateTime) // date/time specific methods for readability
 * 		// other date/time methods are: ::after(), ::before() and ::onOrBefore()
 * ]);
 * ```
 *
 * ### Some, none, all, regex
 *
 * Match documents where the given fields must have values that match a pattern or a list of values:
 *
 * ```php
 * $where = Q::create([
 * 	'category' => Q::matchSome([ 'OfficeSupplies', 'Crafts' ]), // match either value or both
 * 	'status' => Q::matchNone([ 'SoldOut', 'Discontinued' ]),
 * 	'details' => Q::fieldShape([
 * 		'awards' => Q::matchAll([ 'award1', 'award2' ])
 * 	]),
 * 	'name' => Q::regex('^pen.*'),
 * ]);
 * ```
 *
 * Note the use of {@see ::fieldShape()} to query inside a structured field (eg. a JSON column).
 *
 * ### Logical operators
 *
 * Match documents where a field must match an aggregate of expressions:
 *
 * ```php
 * $where = Q::create([
 * 	'category' => Q::and([
 * 		Q::neq('Discontinued'),
 * 		Q::regex('^Arts')
 * 	]),
 * 	'stock' => Q::or([
 * 		Q::gt(0),
 * 		Q::eq(-1) // eq = equal
 * 	])
 * ]);
 * ```
 *
 * ### Comparing against other fields
 *
 * Match documents where a field is compared against a value from another field that can be reached
 * from the document:
 *
 * ```php
 * $where = Q::create([
 * 	// query products where 'category.name' equals the product 'name'
 * 	'category' => Q::referenceShape([
 * 		'name' => Q::valueAt([ 'name' ])
 * 	]),
 * 	// you can also select a value inside a structured field
 * 	'stock' => Q::lte(Q::valueAt([ 'details' ], [ 'stockInfo', 'maximum' ]))
 * ]);
 * ```
 *
 * Note that `valueAt()` can be used in the root shape, but also inside `referenceShape()`'s and `fieldShape()`'s.
 *
 * ### Following references
 *
 * Match documents where a referenced document must match a given shape:
 *
 * ```php
 * $where = Q::create([
 * 	'category' => Q::referenceShape([
 * 		'name' => 'CategoryName',
 * 		'visible' => true,
 * 		'parent' => Q::referenceShape([
 * 			'visible' => true
 * 		])
 * 	])
 * ]);
 * ```
 *
 * ### Querying inner structures
 *
 * Match document where the inner structure of a field must match a given shape:
 *
 * ```php
 * $where = Q::create([
 * 	'details' => Q::fieldShape([
 * 		'score' => Q::fieldShape([
 * 			'average' => Q::gte(0.75)
 * 		])
 * 	])
 * ]);
 * ```
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DocumentShape {

	/** @var Closure(non-empty-list<Predicate>):Predicate\And_ */
	private const Closure DEFAULT_AGGREGATE = self::newAndPredicateAggregate(...);

	/**
	 * Shorthand to query an entity that has the given ID.
	 * @since 1.0
	 */
	public static function createForId(Entity\UniqueIdentifier|Entity\SequentialValue|string|int $id): Predicate\Equal {
		return new Predicate\Equal(new ValuePath([ 'id' ]), $id);
	}

	/**
	 * Produces a predicate where a document must match the given shape.
	 * @since 1.0
	 * @see ::referenceShape() To create a shape for a document that is referenced by a field
	 * @see ::fieldShape() To create a shape for a nested field structure
	 * @param non-empty-array<non-empty-string,(Closure(ValuePath):Predicate)|DateTimeInterface|BackedEnum|string|float|int|bool|null> $shape
	 * @param Closure(non-empty-list<Predicate>):PredicateAggregate $aggregate Aggregates the inputs
	 */
	public static function create(array $shape, Closure $aggregate = self::DEFAULT_AGGREGATE): PredicateAggregate {
		return $aggregate(self::resolveDocumentShape([ ], $shape));
	}

	/**
	 * Produces a predicate where the document referenced by a field must match a specific shape.
	 *
	 * This method can no longer be used after entering the shape of a structured field.
	 *
	 * @since 1.0
	 * @param non-empty-array<non-empty-string,(Closure(ValuePath):Predicate)|DateTimeInterface|BackedEnum|string|float|int|bool|null> $shape
	 * @param Closure(non-empty-list<Predicate>):PredicateAggregate $aggregate Aggregates the inputs
	 * @return Closure(ValuePath):PredicateAggregate
	 */
	public static function referenceShape(array $shape, Closure $aggregate = self::DEFAULT_AGGREGATE): Closure {
		return fn(ValuePath $path) => \count($path->innerPath) > 0
			? throw new LogicException('Unexpected reference shape inside a field shape')
			: $aggregate(self::resolveDocumentShape($path->fieldPath, $shape));
	}

	/**
	 * Produces a predicate where the inner/nested structure of a field must match a specific shape.
	 * @since 1.0
	 * @param non-empty-array<string,(Closure(ValuePath):Predicate)|DateTimeInterface|BackedEnum|string|float|int|bool|null> $shape
	 * @param Closure(non-empty-list<Predicate>):PredicateAggregate $aggregate Aggregates the inputs
	 * @return Closure(ValuePath):PredicateAggregate
	 */
	public static function fieldShape(array $shape, Closure $aggregate = self::DEFAULT_AGGREGATE): Closure {
		return fn(ValuePath $path) => $aggregate(self::resolveFieldShape($path, $shape));
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<(Closure(ValuePath):Predicate)> $inputs
	 * @return Closure(ValuePath):Predicate\And_
	 */
	public static function and(array $inputs): Closure {
		return static function(ValuePath $path) use ($inputs) {
			return $inputs
				|> (fn($x) => \array_map(fn($inputCreator) => $inputCreator($path), $x))
				|> (fn($x) => new Predicate\And_($x));
		};
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<(Closure(ValuePath):Predicate)> $inputs
	 * @return Closure(ValuePath):Predicate\Or_
	 */
	public static function or(array $inputs): Closure {
		return static function(ValuePath $path) use ($inputs) {
			return $inputs
				|> (fn($x) => \array_map(fn($inputCreator) => $inputCreator($path), $x))
				|> (fn($x) => new Predicate\Or_($x));
		};
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\Equal
	 */
	public static function eq(DateTimeInterface|BackedEnum|string|float|int|bool|null $rhs): Closure {
		return static fn(ValuePath $field) => new Predicate\Equal($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\NotEqual
	 */
	public static function neq(DateTimeInterface|BackedEnum|string|float|int|bool|null $rhs): Closure {
		return static fn(ValuePath $field) => new Predicate\NotEqual($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\GreaterThan
	 */
	public static function gt(ValuePath|float|int $rhs): Closure {
		return static fn(ValuePath $field) => new Predicate\GreaterThan($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\GreaterThanOrEqual
	 */
	public static function gte(ValuePath|float|int $rhs): Closure {
		return static fn(ValuePath $field) => new Predicate\GreaterThanOrEqual($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\LessThan
	 */
	public static function lt(ValuePath|float|int $rhs): Closure {
		return static fn(ValuePath $field) => new Predicate\LessThan($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\LessThanOrEqual
	 */
	public static function lte(ValuePath|float|int $rhs): Closure {
		return static fn(ValuePath $field) => new Predicate\LessThanOrEqual($field, $rhs);
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<DateTimeInterface|BackedEnum|string|float|int|bool|null> $values
	 * @return Closure(ValuePath):Predicate\MatchAll
	 */
	public static function matchAll(array $values): Closure {
		return static fn(ValuePath $field) => new Predicate\MatchAll($field, $values);
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<DateTimeInterface|BackedEnum|string|float|int|bool|null> $values
	 * @return Closure(ValuePath):Predicate\MatchSome
	 */
	public static function matchSome(array $values): Closure {
		return static fn(ValuePath $field) => new Predicate\MatchSome($field, $values);
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<DateTimeInterface|BackedEnum|string|float|int|bool|null> $values
	 * @return Closure(ValuePath):Predicate\MatchNone
	 */
	public static function matchNone(array $values): Closure {
		return static fn(ValuePath $field) => new Predicate\MatchNone($field, $values);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\MatchRegex
	 */
	public static function regex(string $regex): Closure {
		return static fn(ValuePath $field) => new Predicate\MatchRegex($field, $regex);
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
	 * @return Closure(ValuePath):Predicate\Or_
	 */
	public static function isEmpty(): Closure {
		return static fn(ValuePath $field) => new Predicate\Or_([
			new Predicate\NotExists($field),
			new Predicate\MatchSome($field, [ null, '' ])
		]);
	}

	/**
	 * @since 1.0
	 * @see ::isEmpty() For a description of when a field is considered empty
	 * @return Closure(ValuePath):Predicate\And_
	 */
	public static function isNonEmpty(): Closure {
		return static fn(ValuePath $field) => new Predicate\And_([
			new Predicate\Exists($field),
			new Predicate\MatchNone($field, [ null, '' ])
		]);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\LessThan
	 */
	public static function before(DateTimeInterface $at): Closure {
		return static fn(ValuePath $field) => new Predicate\LessThan($field, $at);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\LessThanOrEqual
	 */
	public static function onOrBefore(DateTimeInterface $at): Closure {
		return static fn(ValuePath $field) => new Predicate\LessThanOrEqual($field, $at);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\GreaterThan
	 */
	public static function after(DateTimeInterface $at): Closure {
		return static fn(ValuePath $field) => new Predicate\GreaterThan($field, $at);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):Predicate\GreaterThanOrEqual
	 */
	public static function onOrAfter(DateTimeInterface $at): Closure {
		return static fn(ValuePath $field) => new Predicate\GreaterThanOrEqual($field, $at);
	}

	/**
	 * Selects a value by path.
	 *
	 * Essentially a shorthand for `new ValuePath` that saves an import.
	 *
	 * @since 1.0
	 * @see ValuePath
	 * @param non-empty-list<non-empty-string> $fields
	 * @param list<string> $inner
	 */
	public static function valueAt(array $fields, array $inner = [ ]): ValuePath {
		return new ValuePath($fields, $inner);
	}

	/**
	 * @param list<non-empty-string> $basePath
	 * @param non-empty-array<non-empty-string,(Closure(ValuePath):Predicate)|DateTimeInterface|BackedEnum|string|float|int|bool|null> $shape
	 * @return non-empty-list<Predicate>
	 */
	private static function resolveDocumentShape(array $basePath, array $shape): array {
		$out = [ ];
		foreach ($shape as $field => $spec) {
			$newPath = $basePath;
			$newPath[] = $field;
			$fullPath = new ValuePath($newPath);

			$out[] = $spec instanceof Closure
				? $spec($fullPath)
				: new Predicate\Equal($fullPath, $spec);
		}
		return $out;
	}

	/**
	 * @param non-empty-array<string,(Closure(ValuePath):Predicate)|DateTimeInterface|BackedEnum|string|float|int|bool|null> $shape
	 * @return non-empty-list<Predicate>
	 */
	private static function resolveFieldShape(ValuePath $base, array $shape): array {
		$out = [ ];
		foreach ($shape as $field => $spec) {
			$newInnerPath = $base->innerPath;
			$newInnerPath[] = $field;
			$fullPath = new ValuePath($base->fieldPath, $newInnerPath);

			$out[] = $spec instanceof Closure
				? $spec($fullPath)
				: new Predicate\Equal($fullPath, $spec);
		}
		return $out;
	}

	/** @param non-empty-list<Predicate> $inputs */
	private static function newAndPredicateAggregate(array $inputs): Predicate\And_ { // @phpstan-ignore method.unused (bug?)
		return new Predicate\And_($inputs);
	}

	private function __construct() { }

}
