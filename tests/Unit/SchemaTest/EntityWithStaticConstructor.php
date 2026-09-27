<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Common\UniqueIdentifier;
use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithStaticConstructor implements Entity, Entity\FromFields {

	public static function fromFields(
		UniqueIdentifier $id,
		string $overrideName,
	): self {
		return new self($id, $overrideName);
	}

	public function __construct(

		#[Override]
		public UniqueIdentifier $id,

		public string $originalName,

	) { }

}
