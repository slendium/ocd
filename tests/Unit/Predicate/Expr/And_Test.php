<?php

namespace Slendium\OcdTests\Unit\Predicate\Expr;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate\Expr;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class And_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expr = new Expr\Exists(new FieldPath([ 'test' ]));

		$result = new Expr\And_(inputs: [ $expr ]);

		$this->assertSame(1, \count($result->inputs));
		$this->assertSame($expr, $result->inputs[0]);
	}

}
