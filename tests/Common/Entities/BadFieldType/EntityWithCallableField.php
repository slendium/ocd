<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldType;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithCallableField implements Entity {

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		callable $field,

	) {
		$_ = $field();
	}

}
