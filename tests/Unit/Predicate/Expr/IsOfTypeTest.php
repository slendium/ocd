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
final class IsOfTypeTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$storageClass = StorageClass::String;

		$result = new Expr\IsOfType(field: $field, storageClass: $storageClass);

		$this->assertSame($field, $result->field);
		$this->assertSame($storageClass, $result->storageClass);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Expr\IsOfType(new FieldPath([ 'foo' ]), StorageClass::Int);
		$called = false;
		$mock = new MockVisitor([ 'visitIsOfType' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
