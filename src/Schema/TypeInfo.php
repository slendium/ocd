<?php

namespace Slendium\Ocd\Schema;

use ReflectionMethod;
use ReflectionNamedType;
use ReflectionUnionType;

/**
 * Meta information provider about "schema {@see Type}'s."
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class TypeInfo {

	/**
	 * Returns the type that the given "schema type" serializes to.
	 * @since 1.0
	 * @param class-string<Type> $typeClass
	 * @return class-string|'array'|'string'|'float'|'int'|'bool'
	 */
	public static function getSerializeType(string $typeClass): string {
		$reflectedType = new ReflectionMethod($typeClass, 'serialize')->getReturnType();

		if ($reflectedType instanceof ReflectionNamedType) {
			return self::getSerializedTypeFromNamedType($reflectedType, $typeClass);
		} else if ($reflectedType instanceof ReflectionUnionType) {
			return self::getSerializedTypeFromUnionType($reflectedType, $typeClass);
		}

		throw TypeException::forAmbiguousSerialization($typeClass, $reflectedType);
	}

	/** @return class-string|'array'|'string'|'float'|'int'|'bool' */
	private static function getSerializedTypeFromUnionType(ReflectionUnionType $union, string $typeClass): string {
		$types = $union->getTypes();
		if (\count($types) > 3) {
			throw TypeException::forAmbiguousSerialization($typeClass, $union);
		}

		$serializedTypes = [ ];
		foreach ($types as $type) {
			if (!($type instanceof ReflectionNamedType)) {
				throw TypeException::forAmbiguousSerialization($typeClass, $union);
			}

			$name = $type->getName();
			if ($name !== 'null' && $name !== Type\SerializeException::class) {
				$serializedTypes[] = self::getSerializedTypeFromNamedType($type, $typeClass);
			}
		}

		return \count($serializedTypes) !== 1
			? throw TypeException::forAmbiguousSerialization($typeClass, $union)
			: $serializedTypes[0];
	}

	/** @return class-string|'array'|'string'|'float'|'int'|'bool' */
	private static function getSerializedTypeFromNamedType(ReflectionNamedType $type, string $typeClass): string {
		return !$type->isBuiltin() || self::isSerializableBuiltin($type->getName()) // @phpstan-ignore return.type
			? $type->getName()
			: throw TypeException::forUnsupportedSerialization($typeClass, $type->getName());
	}

	/** @phpstan-assert-if-true 'array'|'string'|'float'|'int'|'bool' $name */
	private static function isSerializableBuiltin(string $name): bool {
		return match($name) {
			'array', 'string', 'float', 'int', 'bool' => true,
			default => false
		};
	}

	private function __construct() { }

}
