<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class ObjectWithExcludedIdField {

	public function __construct(

		#[Schema\Exclude]
		public string $id,

	) { }

}
