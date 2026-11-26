<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use Exception;
use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityFromFields implements Entity, Entity\FromFields {

	public static function fromFields(string $id, string $field): self {
		return new self($id, $field, false);
	}

	private function __construct(

		#[Override]
		public string $id,

		#[MockStringType]
		public string $field,

		bool $throw = true,

	) {
		if ($throw) {
			throw new Exception('Should not throw during reassembly');
		}
	}

}
