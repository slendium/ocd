<?php

namespace Slendium\OcdTests\Common\Entities\BadSchemaAttributes;

use Override;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;
use Slendium\OcdTests\Common\Entities\ObjectWithoutFields;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Schema\Constraint\Reference(ObjectWithoutFields::class, [ 'field' => 'id' ])]
final readonly class ReferenceToNowhere implements Entity {

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		public string $field,

	) { }

}
