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
final class MatchNoneTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = new FieldPath([ 'test' ]);
		$values = [ 'string', 25, true ];

		$result = new Expr\MatchNone(field: $field, values: $values);

		$this->assertSame($field, $result->field);
		$this->assertSame($values, $result->values);
	}

}
