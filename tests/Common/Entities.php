<?php

namespace Slendium\OcdTests\Common;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Entities {

	/** @return iterable<int,class-string> */
	public static function getAllInvalidClasses(): iterable {
		yield from self::getClassesWithInvalidFieldType();
		yield from self::getClassesInSubNamespace('BadFieldReference');
		yield from self::getClassesInSubNamespace('BadSchemaAttributes');
	}

	/** @return iterable<int,class-string> */
	public static function getClassesWithInvalidFieldType(): iterable {
		yield from self::getClassesInSubNamespace('BadFieldType');
	}

	/** @return iterable<int,class-string> */
	private static function getClassesInSubNamespace(string $subNamespace): iterable {
		foreach (\glob(__DIR__."/Entities/$subNamespace/*.php") as $path) { // @phpstan-ignore foreach.nonIterable (glob wont be false)
			yield __NAMESPACE__."\\Entities\\$subNamespace\\".\basename($path, '.php'); // @phpstan-ignore generator.valueType
		}
	}

}
