<?php

namespace Slendium\OcdTests\Common\Entities\BadSchemaAttributes;

use Slendium\Ocd\Schema\PrimaryFields;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[PrimaryFields([ 'does', 'not', 'exist' ])]
final readonly class NonExistentPrimary {

	public function __construct(

		public string $id,

		public int $count,

	) { }

}
