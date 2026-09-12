<?php

namespace Slendium\OcdTests\Unit\Predicate\Expr;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate\Expr;

use Slendium\OcdTests\Unit\Predicate\MockVisitor;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Or_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expr = new Expr\Exists(new FieldPath([ 'test' ]));

		$result = new Expr\Or_(inputs: [ $expr ]);

		$this->assertSame(1, \count($result->inputs));
		$this->assertSame($expr, $result->inputs[0]);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Expr\Or_([ new Expr\Exists(new FieldPath([ 'foo' ])) ]);
		$called = false;
		$mock = new MockVisitor([ 'visitOr' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
