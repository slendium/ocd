<?php

namespace Slendium\Ocd\Schema;

use Slendium\Ocd\Common\Blob;

/**
 * Responsible for validating and converting between input values and values to be stored in the database.
 *
 * While input values could come directly from end users, schema types are intended to ensure that your
 * own code or third party plugins don't accidentally (or maliciously) pass invalid values directly
 * to the database.
 *
 * Database implementations extract the storage type of a field by analyzing its schema type.
 * To specify a storage type, implementations must declare a return type for the {@see ::serialize()} method.
 * The return type must be either a class, `array`, `string`, `float`, `int`, or `bool`, may be nullable,
 * and may be a union with {@see Type\SerializeException}, but all other DNF types are disallowed.
 *
 * Database implementations are free to reject any type except {@see \DateTimeInterface}, {@see \BackedEnum},
 * {@see \Slendium\Ocd\Common\Blob}, and the builtin types mentioned above.
 *
 * ## Example
 *
 * A schema type that only allows integers within a given range.
 *
 * ```php
 * class RangedInt implements Type {
 *
 * 	public function __construct(private int $min, private int $max) { }
 *
 * 	#[Override]
 * 	public function serialize(mixed $input): SerializeException|int|null {
 * 		if (!\is_numeric($input)) {
 * 			return new SerializeException('Expected value to be numeric');
 * 		}
 *
 * 		if (!\is_finite($input)) {
 * 			return new SerializeException("Expected value to be finite, not `$input`");
 * 		}
 *
 * 		$input = (int)$input;
 * 		return $input >= $this->min && $input <= $this->max
 * 			? $input
 * 			: new SerializeException("Expected value to be in range `{$this->min}..{$this->max}`, `$input` given");
 * 	}
 *
 * 	// ...
 *
 * }
 * ```
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Type {

	/**
	 * Serializes a given value into its database-stored representation.
	 *
	 * If the given value can't be serialized, a {@see Type\SerializeException} should be returned.
	 *
	 * If a given value is basically equivalent to the "default value" for the type, this method
	 * should return `null`.
	 *
	 * @since 1.0
	 */
	public function serialize(mixed $value): mixed;

	/**
	 * Converts a database-stored representation of a value back into the real value.
	 * @since 1.0
	 * @param object|iterable<mixed>|string|float|int|bool|null $stored
	 */
	public function deserialize(object|iterable|string|float|int|bool|null $stored): mixed;

}
