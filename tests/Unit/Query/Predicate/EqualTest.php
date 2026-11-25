<?php

namespace Slendium\OcdTests\Unit\Query\Predicate;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\ValuePath;

use Slendium\OcdTests\Unit\Query\MockPredicateVisitor;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class EqualTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$lhs = new ValuePath([ 'test' ]);
		$rhs = 'literal string';

		$result = new Predicate\Equal(lhs: $lhs, rhs: $rhs);

		$this->assertSame($lhs, $result->lhs);
		$this->assertSame($rhs, $result->rhs);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Predicate\Equal(new ValuePath([ 'test' ]), 'foo');
		$called = false;
		$mock = new MockPredicateVisitor([ 'visitEqual' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
