<?php

namespace Slendium\OcdTests\Unit\Schema\Constraint;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Constraint\Invariant;
use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\ValuePath;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class InvariantTest extends TestCase {

	public function test___construct_shouldNotThrow_whenPassingPredicate(): void {
		$predicate = new Predicate\GreaterThan(new ValuePath([ 'foo' ]), 0);

		$sut = new Invariant(condition: $predicate);

		$this->assertSame($predicate, $sut->condition);
	}

	public function test___construct_shouldCallGivenClosureToProduceCondition(): void {
		$predicate = new Predicate\LessThan(new ValuePath([ 'foo' ]), 0);

		$sut = new Invariant(condition: fn() => $predicate);

		$this->assertSame($predicate, $sut->condition);
	}

}
