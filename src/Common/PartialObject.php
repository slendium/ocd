<?php

namespace Slendium\Ocd\Common;

use ReflectionClass;
use RuntimeException;

/**
 * Utility for partial objects.
 *
 * Essentially a wrapper around the inconvenient reflection API's of lazy ghost objects.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class PartialObject {

	/**
	 * Creates a potentially partial object from a property map, ignoring any properties not found
	 * on the target class.
	 * @since 1.0
	 * @template T of object
	 * @param ReflectionClass<T> $reflector
	 * @param array<mixed> $properties
	 * @return T
	 */
	public static function create(ReflectionClass $reflector, array $properties): object {
		$ghost = $reflector->newLazyGhost(function($obj) {
			throw new RuntimeException('Unexpected initialization of explicitly partial object');
		});

		foreach ($properties as $name => $value) {
			if ($reflector->hasProperty($name)) {
				$reflector->getProperty($name)->setRawValueWithoutLazyInitialization($ghost, $value);
			}
		}

		return $ghost;
	}

	/** @since 1.0 */
	public static function isPartial(object $object): bool {
		return new ReflectionClass($object)->isUninitializedLazyObject($object);
	}

	private function __construct() { }

}
