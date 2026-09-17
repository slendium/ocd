<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EmptyEntity implements Entity {

	public function __construct(

		#[Override]
		public readonly Entity\Id $id,

	) { }

}
