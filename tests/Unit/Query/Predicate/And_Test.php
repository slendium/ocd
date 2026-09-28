<?php

namespace Slendium\OcdTests\Unit\Query\Predicate;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Query\Predicate;

use Slendium\OcdTests\Unit\Query\MockPredicateVisitor;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class And_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expr = new Predicate\Exists(new FieldPath([ 'test' ]));

		$result = new Predicate\And_(inputs: [ $expr ]);

		$this->assertSame(1, \count($result->inputs));
		$this->assertSame($expr, $result->inputs[0]);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Predicate\And_([ new Predicate\Exists(new FieldPath([ 'test' ])) ]);
		$called = false;
		$mock = new MockPredicateVisitor([ 'visitAnd' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
