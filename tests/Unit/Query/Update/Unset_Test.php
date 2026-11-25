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
final class Unset_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$path = new ValuePath([ 'test' ]);

		$result = new Update\Unset_(path: $path);

		$this->assertSame($path, $result->path);
	}

	public function test_accept_shouldCallAppropriateMethod(): void {
		$sut = new Update\Unset_(new ValuePath([ 'foo' ]));
		$called = false;
		$mock = new MockUpdateVisitor([ 'visitUnset' => function() use (&$called) { $called = true; } ]);

		$sut->accept($mock);

		$this->assertTrue($called);
	}

}
