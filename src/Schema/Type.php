<?php

namespace Slendium\Ocd\Schema;

/**
 * Converts between PHP types and database types.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Type {

	/**
	 * Serializes a given value into its database-stored representation.
	 *
	 * If a given value is basically equivalent to the "default value" for the type, this method
	 * should return `null` instead.
	 *
	 * @since 1.0
	 */
	public function serialize(mixed $value): string|float|int|bool|null;

	/**
	 * Converts a database-stored representation of a value back into the real value.
	 * @since 1.0
	 * @param object|iterable<mixed>|string|float|int|bool|null $stored
	 */
	public function deserialize(object|iterable|string|float|int|bool|null $stored): mixed;

}
