<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldType;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class EntityWithVariadicField implements Entity {

	public function __construct( // @phpstan-ignore constructor.unusedParameter

		#[Override]
		public readonly Entity\UniqueIdentifier $id,

		string ...$field,

	) { }

}
