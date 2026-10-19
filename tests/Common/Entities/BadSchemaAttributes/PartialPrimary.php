<?php

namespace Slendium\OcdTests\Common\Entities\BadSchemaAttributes;

use Slendium\Ocd\Schema\PrimaryFields;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[PrimaryFields([ 'id', 'does_not_exist' ])]
final readonly class PartialPrimary {

	public function __construct(

		public string $id,

		public int $count,

	) { }

}
