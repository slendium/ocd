<?php

namespace Slendium\OcdTests\Unit\Predicate\Expr;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate\Expr;
use Slendium\Ocd\Schema\StorageClass;

use Slendium\OcdTests\Unit\Predicate\MockVisitor;

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

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Expr\NotOfType(new FieldPath([ 'foo' ]), StorageClass::Float);
		$called = false;
		$mock = new MockVisitor([ 'visitNotOfType' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
