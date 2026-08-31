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
	public static function forAmbiguousSerialization(string $ocdType, ?ReflectionType $outType): self {
		if ($outType === null) {
			return new self("Expected serialize() to have a return type hint for OCD type `$ocdType`");
		}

		return new self(''
			."Unexpected ambiguous serialize() return type hint for OCD type `$ocdType`, "
			."expected a named type, for example `?string`, not `$outType`"
		);
	}

	/** @internal */
	public static function forUnsupportedSerialization(string $ocdType, string $outType): self {
		return new self(''
			."Unexpected unsupported serialize() return type for OCD type `$ocdType`"
		);
	}

}
