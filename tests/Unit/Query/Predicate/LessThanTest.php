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
final class LessThanTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$lhs = new FieldPath([ 'test' ]);
		$rhs = 10;

		$result = new Predicate\LessThan(lhs: $lhs, rhs: $rhs);

		$this->assertSame($lhs, $result->lhs);
		$this->assertSame($rhs, $result->rhs);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Predicate\LessThan(new FieldPath([ 'foo' ]), 0);
		$called = false;
		$mock = new MockPredicateVisitor([ 'visitLessThan' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
