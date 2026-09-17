<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithScalarFields implements Entity {

	public function __construct(

		#[Override]
		public Entity\Id $id,

		public string $string,

		public float $float,

		public int $int,

		public bool $bool,

	) { }

}
