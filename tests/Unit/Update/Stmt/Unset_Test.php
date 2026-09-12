<?php

namespace Slendium\OcdTests\Unit\Update\Stmt;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Update\Stmt;

use Slendium\OcdTests\Unit\Update\MockVisitor;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Unset_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);

		$result = new Stmt\Unset_(field: $field);

		$this->assertSame($field, $result->field);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Stmt\Unset_(new FieldPath([ 'foo' ]));
		$called = false;
		$mock = new MockVisitor([ 'visitUnset' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
