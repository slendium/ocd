<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithStringField implements Entity {

	public function __construct(

		#[Override]
		public string $id,

		#[MockStringType]
		public string $field,

	) { }

}
