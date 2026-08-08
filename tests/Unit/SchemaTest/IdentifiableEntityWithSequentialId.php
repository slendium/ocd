<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class IdentifiableEntityWithSequentialId implements Entity, Entity\Identifiable {

	public function __construct(

		#[Override, Schema\IdOptions(Schema\IdGenerator::Sequence)]
		public Entity\Id $id,

	) { }

}
