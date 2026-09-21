<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class UnitEnumFieldEntity implements Entity {

	public function __construct(

		#[Override]
		public Entity\Id $id,

		public FakeUnitEnum $enumeration,

	) { }

}
