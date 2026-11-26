<?php

namespace Slendium\Ocd\Schema;

use Generator;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Fields {

	/**
	 * Creates a generator for the given class that iterates all valid field parameters.
	 * @param ReflectionClass<object> $reflector
	 * @return iterable<ReflectionParameter>
	 */
	public static function getFieldParametersFromClass(ReflectionClass $reflector): iterable {
		$method = self::getFieldsMethod($reflector);
		if ($method !== null) {
			yield from self::getFieldParametersFromMethod($method);
		}
	}

	/**
	 * Creates a generator for the given method that iterates all valid field parameters.
	 *
	 * The return value of the generator contains the parameters that were excluded.
	 *
	 * @return Generator<int, ReflectionParameter, mixed, list<ReflectionParameter>>
	 */
	public static function getFieldParametersFromMethod(ReflectionMethod $method): Generator {
		$excluded = [ ];

		foreach ($method->getParameters() as $parameter) {
			if ($parameter->isVariadic()) {
				throw DefinitionException::forVariadicParameter($parameter->name);
			}

			if (Exclude::isMarked($parameter)) {
				$excluded[] = $parameter;
				continue;
			}

			yield $parameter;
		}

		return $excluded;
	}

	/** @param ReflectionClass<object> $reflector */
	public static function getFieldsMethod(ReflectionClass $reflector): ?ReflectionMethod {
		return \is_a($reflector->name, Entity\FromFields::class, allow_string: true)
			? $reflector->getMethod('fromFields')
			: $reflector->getConstructor();
	}

	private function __construct() { }

}
