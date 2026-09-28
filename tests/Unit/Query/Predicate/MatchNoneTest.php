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
final class MatchNoneTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$values = [ 'string', 25, true ];

		$result = new Predicate\MatchNone(field: $field, values: $values);

		$this->assertSame($field, $result->field);
		$this->assertSame($values, $result->values);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Predicate\MatchNone(new FieldPath([ 'foo' ]), [ 1, 2, 3 ]);
		$called = false;
		$mock = new MockPredicateVisitor([ 'visitMatchNone' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
