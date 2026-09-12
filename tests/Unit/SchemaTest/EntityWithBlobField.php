<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Common\Blob;
use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithBlobField implements Entity, Entity\Identifiable {

	public function __construct(

		#[Override]
		public Entity\Id $id,

		public Blob $blob,

	) { }

}
