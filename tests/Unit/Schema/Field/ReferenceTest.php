<?php

namespace Slendium\OcdTests\Unit\Schema\Field;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Constraint\ConstraintAction;
use Slendium\Ocd\Schema\Constraint\Reference as ReferenceConstraint;
use Slendium\Ocd\Schema\Field\Reference;
use Slendium\OcdTests\Common\Entities\EntityWithId;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class ReferenceTest extends TestCase {

	public function test___construct_shouldMatchReferenceConstraintDefaults(): void {
		$expected = new ReferenceConstraint(EntityWithId::class, [ 'foo' => 'id' ]);

		$result = new Reference;

		$this->assertSame($expected->onUpdate, $result->onUpdate);
		$this->assertSame($expected->onDelete, $result->onDelete);
	}

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = ConstraintAction::SetNull;

		$result = new Reference(onUpdate: $expectedResult, onDelete: $expectedResult);

		$this->assertSame($expectedResult, $result->onUpdate);
		$this->assertSame($expectedResult, $result->onDelete);
	}

}
