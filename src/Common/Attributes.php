<?php

namespace Slendium\Ocd\Common;

use ReflectionClass;
use ReflectionParameter;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Attributes {

	/**
	 * @param ReflectionClass<object>|ReflectionParameter $reflector
	 * @param class-string $class
	 */
	public static function isMarked(ReflectionClass|ReflectionParameter $reflector, string $class): bool {
		return isset($reflector->getAttributes($class)[0]);
	}

	/**
	 * @template T of object
	 * @param ReflectionClass<object>|ReflectionParameter $reflector
	 * @param class-string<T> $class
	 * @return ?T
	 */
	public static function getFirstInstance(ReflectionClass|ReflectionParameter $reflector, string $class): ?object {
		$attrs = $reflector->getAttributes($class);
		return isset($attrs[0])
			? $attrs[0]->newInstance()
			: null;
	}

	private function __construct() { }

}
