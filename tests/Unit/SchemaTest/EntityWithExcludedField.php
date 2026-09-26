<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithExcludedField implements Entity {

	public function __construct(

		#[Override]
		public string $id,

		public string $included,

		#[Schema\Exclude]
		public string $excluded,

	) { }

}
