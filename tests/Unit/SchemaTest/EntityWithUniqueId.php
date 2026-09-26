<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Common\UniqueIdentifier;
use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithUniqueId implements Entity {

	public function __construct(

		#[Override]
		public UniqueIdentifier $id,

	) { }

}
