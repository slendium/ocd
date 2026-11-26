<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithObjectReference implements Entity {

	public function __construct(

		#[Override]
		public string $id,

		public ReferencedObject $ref,

	) { }

}
