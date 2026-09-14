<?php

namespace Slendium\Ocd\Schema;

use ReflectionNamedType;
use ReflectionParameter;

use Slendium\Ocd\Common\Blob;

/**
 * Defines a field within a schema.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Field {

	/** @internal */
	public static function fromParameter(ReflectionParameter $parameter): self {
		$typeInfo = self::extractTypeInfo($parameter);
		return new self(
			name: self::extractName($parameter),
			type: $typeInfo['type'],
			isNullable: $typeInfo['isNullable'],
			defaultValue: $parameter->isOptional()
				? $parameter->getDefaultValue()
				: null,
			originalName: $parameter->name, // @phpstan-ignore argument.type (never non-empty)
		);
	}

	private function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-string
		 */
		public string $name,

		/** @since 1.0 */
		public Type $type,

		/** @since 1.0 */
		public bool $isNullable,

		/** @since 1.0 */
		public mixed $defaultValue,

		/**
		 * Contains the name of the field before being renamed by the {@see FieldName} attribute.
		 *
		 * Ie. it contains the name of the function parameter which the field definition is based on.
		 *
		 * @since 1.0
		 * @var non-empty-string
		 */
		public string $originalName,

	) { }

	/** @return non-empty-string */
	private static function extractName(ReflectionParameter $parameter): string {
		foreach ($parameter->getAttributes(FieldName::class) as $attr) {
			return $attr->newInstance()->name;
		}
		return $parameter->name; // @phpstan-ignore return.type (cant be empty string)
	}

	/** @return array{ type: Type, isNullable: bool } */
	private static function extractTypeInfo(ReflectionParameter $parameter): array {
		$type = $parameter->getType();
		if (!($type instanceof ReflectionNamedType)) {
			throw $type === null
				? DefinitionException::forMissingFieldType($parameter->name)
				: DefinitionException::forUnsupportedFieldType($parameter->name, $type);
		}

		return [
			'type' => match($type->getName()) {
				Blob::class => Type\Blob::instance(),
				'string' => Type\String_::instance(),
				'float' => Type\Float_::instance(),
				'int' => Type\Int_::instance(),
				'bool' => Type\Bool_::instance(),
				default => throw DefinitionException::forUnsupportedFieldType($parameter->name, $type->getName())
			},
			'isNullable' => $type->allowsNull()
				// parameters that default to null without a nullable type are deprecated since PHP 8.5
				// so this case can be removed when PHP removes support for implied nullable parameters
				|| $parameter->isOptional() && $parameter->getDefaultValue() === null
		];
	}

}
