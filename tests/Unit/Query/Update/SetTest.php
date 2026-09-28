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
final class SetTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$value = \M_PI;

		$result = new Update\Set(field: $field, value: $value);

		$this->assertSame($field, $result->field);
		$this->assertSame($value, $result->value);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Update\Set(new FieldPath([ 'foo' ]), 2);
		$called = false;
		$mock = new MockUpdateVisitor([ 'visitSet' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
