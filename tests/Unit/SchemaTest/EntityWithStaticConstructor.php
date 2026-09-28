<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithStaticConstructor implements Entity, Entity\FromFields {

	public static function fromFields(
		Entity\UniqueIdentifier $id,
		string $overrideName,
	): self {
		return new self($id, $overrideName);
	}

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		public string $originalName,

	) { }

}
