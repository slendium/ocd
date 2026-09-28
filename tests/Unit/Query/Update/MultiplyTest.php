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
final class MultiplyTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$amount = 2.5;

		$result = new Update\Multiply(field: $field, amount: $amount);

		$this->assertSame($field, $result->field);
		$this->assertSame($amount, $result->amount);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Update\Multiply(new FieldPath([ 'foo' ]), 2);
		$called = false;
		$mock = new MockUpdateVisitor([ 'visitMultiply' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
