<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Common\SequentialValue;
use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithSequentialId implements Entity {

	public function __construct(

		#[Override]
		public SequentialValue $id,

	) { }

}
