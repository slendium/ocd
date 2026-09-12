<?php

namespace Slendium\Ocd\Schema;

use ReflectionMethod;
use ReflectionNamedType;

/**
 * Meta information provider about "OCD {@see Type}'s."
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class TypeInfo {

	/**
	 * Returns the base storage class for the given schema type.
	 * @since 1.0
	 * @param class-string<Type> $typeClass
	 */
	public static function getStorageClass(string $typeClass): StorageClass {
		$type = new ReflectionMethod($typeClass, 'serialize')->getReturnType();

		if (!($type instanceof ReflectionNamedType)) {
			throw TypeException::forAmbiguousSerialization($typeClass, $type);
		}

		return StorageClass::tryFrom($type->getName())
			?? throw TypeException::forUnsupportedSerialization($typeClass, $type->getName());
	}

	private function __construct() { }

}
