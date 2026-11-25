<?php

namespace Slendium\OcdTests\Unit\Update\Stmt;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Query\Update;
use Slendium\Ocd\Query\ValuePath;

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
		$path = new ValuePath([ 'test' ]);
		$amount = 2.5;

		$result = new Update\Multiply(path: $path, amount: $amount);

		$this->assertSame($path, $result->path);
		$this->assertSame($amount, $result->amount);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Update\Multiply(new ValuePath([ 'foo' ]), 2);
		$called = false;
		$mock = new MockUpdateVisitor([ 'visitMultiply' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
