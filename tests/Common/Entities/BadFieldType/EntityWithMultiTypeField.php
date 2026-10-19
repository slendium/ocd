<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldType;

use Override;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema\Types;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithMultiTypeField implements Entity {

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		#[Types\Int_, Types\String_]
		public string $field,

	) { }

}
