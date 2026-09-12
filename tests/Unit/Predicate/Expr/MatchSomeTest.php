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
final class MatchSomeTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$values = [ 'string', 25, true ];

		$result = new Expr\MatchSome(field: $field, values: $values);

		$this->assertSame($field, $result->field);
		$this->assertSame($values, $result->values);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Expr\MatchSome(new FieldPath([ 'foo' ]), [ 1, 2, 3 ]);
		$called = false;
		$mock = new MockVisitor([ 'visitMatchSome' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
