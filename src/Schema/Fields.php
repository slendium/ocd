<?php

namespace Slendium\Ocd\Schema;

use ReflectionClass;
use ReflectionParameter;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Fields {

	/**
	 * Creates a generator for a class that iterates all valid field parameters.
	 * @param ReflectionClass<object> $reflector
	 * @return iterable<ReflectionParameter>
	 */
	public static function getFieldParameters(ReflectionClass $reflector): iterable {
		$parameters = \is_a($reflector->name, Entity\FromFields::class, allow_string: true)
			? $reflector->getMethod('fromFields')->getParameters()
			: $reflector->getConstructor()?->getParameters() ?? [ ];

		foreach ($parameters as $parameter) {
			if ($parameter->isVariadic()) {
				throw DefinitionException::forVariadicParameter($parameter->name);
			}

			if (Exclude::isMarked($parameter)) {
				continue;
			}

			yield $parameter;
		}
	}

	private function __construct() { }

}
