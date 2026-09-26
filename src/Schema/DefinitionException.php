<?php

namespace Slendium\Ocd\Schema;

use Exception;

/**
 * Thrown when an illogical schema definition is detected.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class DefinitionException extends Exception {

	/** @internal */
	public static function forMissingFieldType(string $name): self {
		return new self("Expected field `$name` to have a defined type");
	}

	/** @internal */
	public static function forUnsupportedFieldType(string $name, string $type): self {
		return new self("Unexpected unsupported type `$type` for field `$name`");
	}

	/** @internal */
	public static function forTooManyTypes(string $name): self {
		return new self("Expected only one schema type for field `$name`");
	}

	/** @internal */
	public static function forMissingIdField(): self {
		return new self('Expected a field named `id` for entity');
	}

}
