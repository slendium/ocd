<?php

namespace Slendium\OcdTests\Unit\Update\Stmt;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Update\Stmt;

/**
 * BC tests. Properties, labeled parameters and constructor defaults should not change.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class AddTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$amount = 1;

		$result = new Stmt\Add(field: $field, amount: $amount);

		$this->assertSame($field, $result->field);
		$this->assertSame($amount, $result->amount);
	}

}
