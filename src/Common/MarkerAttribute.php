<?php

namespace Slendium\Ocd\Common;

use ReflectionClass;
use ReflectionParameter;

/**
 * Internal utility methods that can be attached to unrepeated {@see \Attribute}'s that serve as markers.
 *
 * The attribute implementation must be a `final class`.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
trait MarkerAttribute {

	/**
	 * @param ReflectionClass<object>|ReflectionParameter $reflector
	 * @internal
	 */
	public static function isMarked(ReflectionClass|ReflectionParameter $reflector): bool {
		return Attributes::isMarked($reflector, static::class);
	}

	/**
	 * @param ReflectionClass<object>|ReflectionParameter $reflector
	 * @internal
	 */
	public static function getInstance(ReflectionClass|ReflectionParameter $reflector): ?static {
		return Attributes::getFirstInstance($reflector, static::class);
	}

}
