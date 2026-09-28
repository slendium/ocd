<?php

namespace Slendium\Ocd\Query;

use Closure;

use Slendium\Ocd\Common\FieldPath;

/**
 * Builder utility for document updates.
 *
 * Similar to the {@see \Slendium\Ocd\Predicate\DocumentShape} query builder, but for updates instead.
 *
 * For example, the `SET` clause of an `UPDATE` query can be created as follows:
 *
 * ```php
 * use Slendium\Ocd\Query\DocumentUpdate as SET;
 *
 * $updates = SET::create([
 * 	'name' => 'new literal name',
 * 	'stock' => SET::add(1),
 * 	'reviews' => SET::multiple(
 * 		SET::if($text !== '', SET::path([ 'texts' ], SET::append([ $text ]))),
 * 		SET::path([ 'sumOfScores' ], SET::add(0.8)),
 * 		SET::path([ 'count' ], SET::add(1))
 * 	)
 * ]);
 * ```
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DocumentUpdate {

	/**
	 * Creates a list of document updates.
	 *
	 * Each field update must either be a literal value to set or a `Closure(FieldPath):iterable<Update>`.
	 * Any non-closure value will be converted to a {@see Update\Set} instance.
	 *
	 * @since 1.0
	 * @param non-empty-array<non-empty-string,mixed> $specs
	 * @return list<Update>
	 */
	public static function create(array $specs): array {
		$out = [ ];
		foreach ($specs as $field => $spec) {
			if ($spec instanceof Closure) {
				/** @var Closure(FieldPath):iterable<Update> $spec */
				$stmts = $spec(new FieldPath([ $field ]));
				foreach ($stmts as $stmt) {
					$out[] = $stmt;
				}
			} else {
				$out[] = new Update\Set(new FieldPath([ $field ]), $spec);
			}
		}
		return $out;
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):iterable<Update\Set>
	 */
	public static function set(mixed $value): Closure {
		return static fn(FieldPath $field) => yield new Update\Set($field, $value);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):iterable<Update\Unset_>
	 */
	public static function unset(): Closure {
		return static fn(FieldPath $field) => yield new Update\Unset_($field);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):iterable<Update\Add>
	 */
	public static function add(float|int $amount): Closure {
		return static fn(FieldPath $field) => yield new Update\Add($field, $amount);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):iterable<Update\Multiply>
	 */
	public static function multiply(float|int $amount): Closure {
		return static fn(FieldPath $field) => yield new Update\Multiply($field, $amount);
	}

	/**
	 * @since 1.0
	 * @return Closure(FieldPath):iterable<Update\Append>
	 */
	public static function append(mixed $value): Closure {
		return static fn(FieldPath $field) => yield new Update\Append($field, $value);
	}

	/**
	 * @since 1.0
	 * @param Closure(FieldPath):iterable<Update> $update
	 * @param Closure(FieldPath):iterable<Update> ...$remainder
	 * @return Closure(FieldPath):iterable<Update>
	 */
	public static function multiple(Closure $update, Closure ...$remainder): Closure {
		return static function(FieldPath $field) use ($update, $remainder) {
			yield from $update($field);
			foreach ($remainder as $closure) {
				yield from $closure($field);
			}
		};
	}

	/**
	 * @since 1.0
	 * @param Closure(FieldPath):iterable<Update> $then
	 * @param ?Closure(FieldPath):iterable<Update> $else
	 * @return Closure(FieldPath):iterable<Update>
	 */
	public static function if(bool $condition, Closure $then, ?Closure $else = null): Closure {
		return static function(FieldPath $field) use ($condition, $then, $else) {
			if ($condition) {
				yield from $then($field);
			} else if ($else !== null) {
				yield from $else($field);
			}
		};
	}

	/**
	 * @since 1.0
	 * @param non-empty-list<non-empty-string> $parts
	 * @param Closure(FieldPath):iterable<Update> $wrappee
	 * @return Closure(FieldPath):iterable<Update>
	 */
	public static function path(array $parts, Closure $wrappee): Closure {
		return static fn(FieldPath $base) => yield from $wrappee(new FieldPath([ ...$base->path, ...$parts ]));
	}

}
