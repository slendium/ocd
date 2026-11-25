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
final class MatchAllTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$path = new ValuePath([ 'test' ]);
		$values = [ 'string', 25, true ];

		$result = new Predicate\MatchAll(valueAt: $path, values: $values);

		$this->assertSame($path, $result->valueAt);
		$this->assertSame($values, $result->values);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Predicate\MatchAll(new ValuePath([ 'foo' ]), [ 1, 2, 3 ]);
		$called = false;
		$mock = new MockPredicateVisitor([ 'visitMatchAll' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
