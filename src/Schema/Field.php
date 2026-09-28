<?php

namespace Slendium\Ocd\Schema;

use BackedEnum;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;

use Slendium\Ocd\Common\Blob;
use Slendium\Ocd\Entity\SequentialValue;
use Slendium\Ocd\Entity\UniqueIdentifier;

/**
 * Defines a field within a schema.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Field {

	/**
	 * @since 1.0
	 * @var non-empty-string
	 */
	public string $name; // @phpstan-ignore property.uninitializedReadonly (fromParameter always assigns it)

	/** @internal */
	public static function fromParameter(ReflectionParameter $parameter): self {
		if ($parameter->isVariadic()) {
			throw DefinitionException::forVariadicParameter($parameter->name);
		}

		$classReflector = new ReflectionClass(self::class);
		$field = $classReflector->newLazyGhost(static function(self $object) use ($parameter) {
			$object->__construct(
				type: self::extractTypeInfo($parameter),
				isNullable: $parameter->allowsNull(),
				defaultValue: $parameter->isOptional()
					? $parameter->getDefaultValue()
					: null,
				originalName: $parameter->name, // @phpstan-ignore argument.type (never non-empty)
			);
		});

		$classReflector->getProperty('name')
			->setRawValueWithoutLazyInitialization($field, self::extractName($parameter));
		return $field;
	}

	private function __construct(

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

	private static function extractTypeInfo(ReflectionParameter $parameter): Type {
		$typeAttrs = $parameter->getAttributes(Type::class, ReflectionAttribute::IS_INSTANCEOF);
		if (\count($typeAttrs) > 1) {
			throw DefinitionException::forTooManyTypes($parameter->name);
		}

		foreach ($typeAttrs as $attr) {
			return $attr->newInstance();
		}

		$type = $parameter->getType();
		if (!($type instanceof ReflectionNamedType)) {
			throw $type === null
				? DefinitionException::forMissingFieldType($parameter->name)
				: DefinitionException::forUnsupportedFieldType($parameter->name, $type);
		}

		return self::getSchemaTypeForDeclaredType($type->getName())
			?? throw DefinitionException::forUnsupportedFieldType($parameter->name, $type->getName());
	}

	private static function getSchemaTypeForDeclaredType(string $type): ?Type {
		return match($type) {
			Blob::class => Types\Blob::instance(),
			DateTime::class => Types\DateTimeMutable::instance(),
			DateTimeImmutable::class => Types\DateTime::instance(),
			DateTimeInterface::class => Types\DateTime::instance(),
			SequentialValue::class => Types\SequentialValue::instance(),
			UniqueIdentifier::class => Types\UniqueIdentifier::instance(),
			'array' => new Types\Map,
			'string' => Types\String_::instance(),
			'float' => Types\Float_::instance(),
			'int' => Types\Int_::instance(),
			'bool' => Types\Bool_::instance(),
			default => self::getSchemaTypeForDeclaredClass($type)
		};
	}

	private static function getSchemaTypeForDeclaredClass(string $class): ?Type {
		if (\is_a($class, BackedEnum::class, allow_string: true)) {
			return new Types\Enumeration($class);
		}

		return null;
	}

}
