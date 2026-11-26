<?php

namespace Slendium\Ocd\Schema;

use Exception;
use ReflectionType;

/**
 * Thrown for incorrectly defined types.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class TypeException extends Exception {

	/** @internal */
	public static function forAmbiguousSerialization(string $schemaType, ?ReflectionType $outType): self {
		if ($outType === null) {
			return new self("Expected $schemaType::serialize() to have a return type hint");
		}

		return new self(''
			."Ambiguous return type for $schemaType::serialize(), expected a named type such as `string` "
			."optionally in a union with SerializeException, not `$outType`"
		);
	}

	/** @internal */
	public static function forUnsupportedSerialization(string $schemaType, string $outType): self {
		return new self("Unsupported return type `$outType` for $schemaType::serialize()");
	}

	/** @internal */
	public static function forNullableSerialization(string $schemaType): self {
		return new self("Unexpected nullable return type for $schemaType::serialize()");
	}

}
