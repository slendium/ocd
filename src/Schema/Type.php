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
 * The return type must be either a class, `array`, `Stringable|string`, `float`, `int`, or `bool`
 * and may be in a union with {@see Type\SerializeException}, but all other DNF types are disallowed.
 *
 * Database implementations are free to reject any type except {@see \DateTimeInterface}, {@see \BackedEnum},
 * {@see \Slendium\Ocd\Common\Blob}, and the builtin types mentioned above.
 *
 * ## Storage optimizations
 *
 * A type may implement {@see Type\DefaultSerializable} to save space in semi-structured or schemaless contexts.
 * When a user-supplied value serializes to the default value the field may be omitted altogether.
 *
 * The following type-specific optimization hints are also available to database implemenations:
 *
 * * Implement {@see Type\CharacterLimited} to limit the characters stored by a string type
 * * Implement {@see Type\ByteLimited} to limit the bytes stored by a binary blob type
 * * Implement {@see Type\Sized} to limit the bytes stored by numeric types
 * * Implement {@see Type\Unsigned} to optimize the space used by unsigned numeric values
 *
 * ## Example
 *
 * A schema type that only allows integers within a given range.
 *
 * ```php
 * class RangedInt implements Type, Type\Sized {
 *
 * 	#[Override]
 * 	public int $bytes {
 * 		get => $this->calculateOptimalSizeInBytes();
 * 	}
 *
 * 	public function __construct(private int $min, private int $max) { }
 *
 * 	#[Override]
 * 	public function serialize(mixed $input): SerializeException|int {
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
	 * @since 1.0
	 * @return object|array<mixed>|string|float|int|bool
	 */
	public function serialize(mixed $value): object|array|string|float|int|bool;

	/**
	 * Converts a database-stored representation of a value back into the PHP value.
	 *
	 * May return `null` to indicate the stored value could not be converted back.
	 *
	 * @since 1.0
	 */
	public function deserialize(mixed $stored): mixed;

}
