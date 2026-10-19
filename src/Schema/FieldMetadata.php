<?php

namespace Slendium\Ocd\Schema;

use ReflectionParameter;

/**
 * Contains both a field and its metadata.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class FieldMetadata {

	public static function create(ReflectionParameter $parameter): self {
		$type = Types::fromFieldParameter($parameter);

		return \is_string($type)
			? self::createWithReference($parameter, $type)
			: new self(Field::fromParameterWithType($parameter, $type));
	}

	public function __construct(

		public Field $field,

		public ?Constraint\Reference $reference = null,

	) { }

	/** @param class-string $referencedClass */
	private static function createWithReference(ReflectionParameter $parameter, string $referencedClass): self {
		$reference = Constraint\Reference::createForFieldReference(
			sourceField: $parameter->name, // @phpstan-ignore argument.type (never empty)
			targetClass: $referencedClass,
			options: Field\Reference::getInstance($parameter)
		);

		$type = null;
		foreach ($reference->fieldMapping as $field) {
			$type = $field->type;
		}

		return new self(Field::fromParameterWithType($parameter, $type), $reference);
	}

}
