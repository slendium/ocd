<?php

namespace Slendium\OcdTests\Unit\Predicate\Expr;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Predicate\Expr;
use Slendium\Ocd\Predicate\FieldPath;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class EqualTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$lhs = new FieldPath([ 'test' ]);
		$rhs = 'literal string';

		$result = new Expr\Equal(lhs: $lhs, rhs: $rhs);

		$this->assertSame($lhs, $result->lhs);
		$this->assertSame($rhs, $result->rhs);
	}

}
