<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldReference;

use Override;

use Slendium\Ocd\Entity;
use Slendium\OcdTests\Common\Entities\ObjectWithoutFields;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class ReferenceToNowhere implements Entity {

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		public ObjectWithoutFields $field,

	) { }

}
