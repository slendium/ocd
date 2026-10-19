<?php

namespace Slendium\OcdTests\Unit\Schema\Constraint;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Schema\Constraint\Invariant;
use Slendium\Ocd\Query\Predicate;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class InvariantTest extends TestCase {

	public function test___construct_shouldNotThrow_whenPassingPredicate(): void {
		$predicate = new Predicate\GreaterThan(new FieldPath([ 'foo' ]), 0);

		$sut = new Invariant(condition: $predicate);

		$this->assertSame($predicate, $sut->condition);
	}

	public function test___construct_shouldCallGivenClosureToProduceCondition(): void {
		$predicate = new Predicate\LessThan(new FieldPath([ 'foo' ]), 0);

		$sut = new Invariant(condition: fn() => $predicate);

		$this->assertSame($predicate, $sut->condition);
	}

}
