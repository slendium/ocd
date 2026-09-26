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
final readonly class EntityWithRenamedField implements Entity {

	public function __construct(

		#[Override]
		public string $id,

		#[Schema\FieldName('alternativeName')]
		public string $realName,

	) { }

}
