<?php

namespace Slendium\OcdTests\Unit\Update\Stmt;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Update\Stmt;

use Slendium\OcdTests\Unit\Update\MockVisitor;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SetTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$value = \M_PI;

		$result = new Stmt\Set(field: $field, value: $value);

		$this->assertSame($field, $result->field);
		$this->assertSame($value, $result->value);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Stmt\Set(new FieldPath([ 'foo' ]), 2);
		$called = false;
		$mock = new MockVisitor([ 'visitSet' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
