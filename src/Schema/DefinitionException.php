<?php

namespace Slendium\Ocd\Schema;

use Exception;
use ReflectionParameter;

/**
 * Thrown when an illogical schema definition is detected.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class DefinitionException extends Exception {

	/** @internal */
	public static function forMissingFieldType(ReflectionParameter $field): self {
		$fieldDescription = self::describeField($field);

		return new self("Expected field $fieldDescription to have a type");
	}

	/** @internal */
	public static function forUnsupportedFieldType(ReflectionParameter $field): self {
		$fieldDescription = self::describeField($field);
		$givenType = $field->getType();

		return new self("Unexpected unsupported type `$givenType` for field $fieldDescription");
	}

	/** @internal */
	public static function forTooManyTypes(ReflectionParameter $field): self {
		$fieldDescription = self::describeField($field);

		return new self("Expected only one schema type for field $fieldDescription, found multiple");
	}

	/** @internal */
	public static function forVariadicParameter(string $name): self {
		return new self("Unexpected variadic parameter for definition of field `$name`");
	}

	/**
	 * @internal
	 * @param list<non-empty-string> $expected
	 * @param list<non-empty-string> $given
	 */
	public static function forPrimaryFieldsMismatch(string $class, array $expected, array $given): self {
		$expectation = '('.\implode(', ', \array_map(static fn($name) => "`$name`", $expected)).')';
		$actual = \count($given) > 0
			? '('.\implode(', ', \array_map(static fn($name) => "`$name`", $given)).')'
			: 'none';
		return new self("Expected $class to have primary fields $expectation, got $actual");
	}

	/** @internal */
	public static function forReferenceToNonExistentField(string $name, string $targetClass): self {
		return new self("Unexpected reference to non-existent field `$name` of $targetClass");
	}

	/** @internal */
	public static function forCompositeFieldReference(string $name, string $reference): self {
		return new self("Unexpected reference from field `$name` to object $reference with composite primary");
	}

	/** @internal */
	public static function forEmptyFieldReference(string $name, string $reference): self {
		return new self("Unexpected reference from field `$name` to object $reference without primaries");
	}

	/** @internal */
	public static function forReferenceFieldReference(string $name, string $reference): self {
		return new self("Unexpected reference from field `$name` to object `$reference` with a primary that is itself a reference");
	}

	private static function describeField(ReflectionParameter $parameter): string {
		$name = $parameter->name;
		$fieldOrigin = ($class = $parameter->getDeclaringClass()) !== null
			? "of {$class->name}"
			: 'from function '.$parameter->getDeclaringFunction()->name;

		return "`$name` $fieldOrigin";
	}

}
