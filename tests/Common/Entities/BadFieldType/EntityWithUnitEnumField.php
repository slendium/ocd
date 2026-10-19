<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldType;

use Override;

use Slendium\Ocd\Entity;
use Slendium\OcdTests\Common\FakeUnitEnum;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithUnitEnumField implements Entity {

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		public FakeUnitEnum $field,

	) { }

}
