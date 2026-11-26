<?php

namespace Slendium\Ocd\Schema\Type;

/**
 * A type with a default serialization value other than `null`.
 *
 * Changing the default serialized value requires updating all existing documents where a field was
 * omitted due to it being the default.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface DefaultSerializable {

	/**
	 * Checks if the given serialized value is the default value.
	 *
	 * This check may be used by either schemaless database implementations or when in the context of
	 * a structured field (such as a JSON column) to omit the field from the structure altogether,
	 * saving storage space.
	 *
	 * @since 1.0
	 */
	public function isDefaultSerializeValue(mixed $value): bool;

	/**
	 * Returns the default serialization value.
	 *
	 * Deserializing the returned value must result in the PHP-equivalent of the default value.
	 *
	 * @since 1.0
	 * @return object|array<mixed>|string|float|int|bool
	 */
	public function getDefaultSerializeValue(): object|array|string|float|int|bool;

}
