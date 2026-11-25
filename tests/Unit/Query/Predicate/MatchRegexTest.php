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
final class MatchRegexTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$path = new ValuePath([ 'test' ]);
		$regex = '^test';

		$result = new Predicate\MatchRegex(valueAt: $path, regex: $regex);

		$this->assertSame($path, $result->valueAt);
		$this->assertSame($regex, $result->regex);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Predicate\MatchRegex(new ValuePath([ 'foo' ]), '^bar');
		$called = false;
		$mock = new MockPredicateVisitor([ 'visitMatchRegex' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
