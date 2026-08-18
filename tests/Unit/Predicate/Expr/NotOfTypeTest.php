<?php

namespace Slendium\OcdTests\Unit\Predicate\Expr;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Predicate\Expr;
use Slendium\Ocd\Predicate\FieldPath;
use Slendium\Ocd\Schema\StorageClass;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class NotOfTypeTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$storageClass = StorageClass::String;

		$result = new Expr\NotOfType(field: $field, storageClass: $storageClass);

		$this->assertSame($field, $result->field);
		$this->assertSame($storageClass, $result->storageClass);
	}

}
