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
final class SetTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$value = \M_PI;

		$result = new Stmt\Set(field: $field, value: $value);

		$this->assertSame($field, $result->field);
		$this->assertSame($value, $result->value);
	}

}
