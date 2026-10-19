<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldType;

use BackedEnum;
use Override;
use Stringable;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithUnionIntersectionField implements Entity {

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		public (Stringable&BackedEnum)|string $field,

	) { }

}
