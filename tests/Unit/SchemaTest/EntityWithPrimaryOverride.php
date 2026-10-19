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
#[Schema\PrimaryFields([ 'code' ])]
final readonly class EntityWithPrimaryOverride implements Entity {

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		public string $code,

	) { }

}
