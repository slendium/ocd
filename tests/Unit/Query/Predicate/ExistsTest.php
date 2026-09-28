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
final class ExistsTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);

		$result = new Predicate\Exists(field: $field);

		$this->assertSame($field, $result->field);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Predicate\Exists(new FieldPath([ 'foo' ]));
		$called = false;
		$mock = new MockPredicateVisitor([ 'visitExists' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
