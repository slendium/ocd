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
final class MatchRegexTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$regex = '^test';

		$result = new Predicate\MatchRegex(field: $field, regex: $regex);

		$this->assertSame($field, $result->field);
		$this->assertSame($regex, $result->regex);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Predicate\MatchRegex(new FieldPath([ 'foo' ]), '^bar');
		$called = false;
		$mock = new MockPredicateVisitor([ 'visitMatchRegex' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
