<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldType;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class EntityWithUntypedField implements Entity {

	public function __construct( // @phpstan-ignore missingType.parameter (deliberate)

		#[Override]
		public readonly Entity\UniqueIdentifier $id,

		public $field,

	) { }

}
