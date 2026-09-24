<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Override;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema\Types as SchemaTypes;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class TooManyTypesFieldEntity implements Entity {

	public function __construct(

		#[Override]
		public Entity\Id $id,

		#[SchemaTypes\String_, SchemaTypes\Int_]
		public string $tooMany,

	) { }

}
