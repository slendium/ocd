<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldType;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithIterableField implements Entity {

	/** @param iterable<mixed> $field */
	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		iterable $field,

	) {
		foreach ($field as $_) { }
	}

}
