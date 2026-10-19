<?php

namespace Slendium\Ocd\Schema;

use BackedEnum;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use ReflectionAttribute;
use ReflectionNamedType;
use ReflectionParameter;

use Slendium\Ocd\Common\Blob;
use Slendium\Ocd\Entity;

/**
 * Internal type extraction utilities.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Types {

	/**
	 * Returns the schema type directly associated with the given field parameter.
	 *
	 * 1. A schema type declared directly as an attribute has the highest priority
	 * 2. Then the PHP-native type is checked to see if it can be directly converted to a type
	 * 3. If no type can be found directly, the remaining `class-string` is returned
	 *
	 * The returned `class-string` can be used for further analysis, like trying to convert it to a
	 * {@see Constraint\Reference} constraint.
	 *
	 * @return Type|class-string
	 */
	public static function fromFieldParameter(ReflectionParameter $parameter): Type|string {
		$typeAttrs = $parameter->getAttributes(Type::class, ReflectionAttribute::IS_INSTANCEOF);
		if (\count($typeAttrs) > 1) {
			throw DefinitionException::forTooManyTypes($parameter);
		}

		return isset($typeAttrs[0])
			? $typeAttrs[0]->newInstance()
			: self::getImpliedType($parameter);
	}

	/** @return Type|class-string */
	private static function getImpliedType(ReflectionParameter $parameter): Type|string {
		$type = self::getTypeIdentifier($parameter);
		return match($type) {
			Blob::class => Types\Blob::instance(),
			DateTime::class => Types\DateTimeMutable::instance(),
			DateTimeImmutable::class => Types\DateTime::instance(),
			DateTimeInterface::class => Types\DateTime::instance(),
			Entity\SequentialValue::class => Types\SequentialValue::instance(),
			Entity\UniqueIdentifier::class => Types\UniqueIdentifier::instance(),
			'array' => new Types\Map,
			'string' => Types\String_::instance(),
			'float' => Types\Float_::instance(),
			'int' => Types\Int_::instance(),
			'bool' => Types\Bool_::instance(),
			default => \class_exists($type)
				? self::getTypeImpliedByClass($type)
				: throw DefinitionException::forUnsupportedFieldType($parameter)
		};
	}

	/**
	 * @param class-string $class
	 * @return Type|class-string
	 */
	private static function getTypeImpliedByClass(string $class): Type|string {
		return \is_a($class, BackedEnum::class, allow_string: true)
			? new Types\Enumeration($class)
			: $class;
	}

	private static function getTypeIdentifier(ReflectionParameter $parameter): string {
		$type = $parameter->getType();
		if (!($type instanceof ReflectionNamedType)) {
			throw $type === null
				? DefinitionException::forMissingFieldType($parameter)
				: DefinitionException::forUnsupportedFieldType($parameter);
		}

		return $type->getName();
	}

	private function __construct() { }

}
