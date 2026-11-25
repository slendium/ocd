<?php

namespace Slendium\Ocd\Query;

use Closure;

use Slendium\Ocd\Query\ValuePath;

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
 * 		SET::if($text !== '', SET::innerValue([ 'texts' ], SET::append([ $text ]))),
 * 		SET::innerValue([ 'sumOfScores' ], SET::add(0.8)),
 * 		SET::innerValue([ 'count' ], SET::add(1))
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
				/** @var Closure(ValuePath):iterable<Update> $spec */
				$stmts = $spec(new ValuePath([ $field ]));
				foreach ($stmts as $stmt) {
					$out[] = $stmt;
				}
			} else {
				$out[] = new Update\Set(new ValuePath([ $field ]), $spec);
			}
		}
		return $out;
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):iterable<Update\Set>
	 */
	public static function set(mixed $value): Closure {
		return static fn(ValuePath $path) => yield new Update\Set($path, $value);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):iterable<Update\Unset_>
	 */
	public static function unset(): Closure {
		return static fn(ValuePath $path) => yield new Update\Unset_($path);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):iterable<Update\Add>
	 */
	public static function add(float|int $amount): Closure {
		return static fn(ValuePath $path) => yield new Update\Add($path, $amount);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):iterable<Update\Multiply>
	 */
	public static function multiply(float|int $amount): Closure {
		return static fn(ValuePath $path) => yield new Update\Multiply($path, $amount);
	}

	/**
	 * @since 1.0
	 * @return Closure(ValuePath):iterable<Update\Append>
	 */
	public static function append(mixed $value): Closure {
		return static fn(ValuePath $path) => yield new Update\Append($path, $value);
	}

	/**
	 * @since 1.0
	 * @param Closure(ValuePath):iterable<Update> $update
	 * @param Closure(ValuePath):iterable<Update> ...$remainder
	 * @return Closure(ValuePath):iterable<Update>
	 */
	public static function multiple(Closure $update, Closure ...$remainder): Closure {
		return static function(ValuePath $path) use ($update, $remainder) {
			yield from $update($path);
			foreach ($remainder as $closure) {
				yield from $closure($path);
			}
		};
	}

	/**
	 * @since 1.0
	 * @param Closure(ValuePath):iterable<Update> $then
	 * @param ?Closure(ValuePath):iterable<Update> $else
	 * @return Closure(ValuePath):iterable<Update>
	 */
	public static function if(bool $condition, Closure $then, ?Closure $else = null): Closure {
		return static function(ValuePath $field) use ($condition, $then, $else) {
			if ($condition) {
				yield from $then($field);
			} else if ($else !== null) {
				yield from $else($field);
			}
		};
	}

	/**
	 * Creates a path into a nested structure to update an inner value.
	 * @since 1.0
	 * @param non-empty-list<string> $parts
	 * @param Closure(ValuePath):iterable<Update> $update
	 * @return Closure(ValuePath):iterable<Update>
	 */
	public static function innerValue(array $parts, Closure $update): Closure {
		return static function(ValuePath $base) use ($parts, $update) {
			yield from $update(new ValuePath($base->fieldPath, $parts));
		};
	}

}
