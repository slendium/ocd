<?php

namespace Slendium\OcdTests\Unit\Update\Stmt;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Query\Update;

use Slendium\OcdTests\Unit\Query\MockUpdateVisitor;

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

		$result = new Update\Unset_(field: $field);

		$this->assertSame($field, $result->field);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Update\Unset_(new FieldPath([ 'foo' ]));
		$called = false;
		$mock = new MockUpdateVisitor([ 'visitUnset' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
