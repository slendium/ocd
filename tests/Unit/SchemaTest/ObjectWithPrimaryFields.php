<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Schema\PrimaryFields(self::EXPECTED_PRIMARIES)]
final class ObjectWithPrimaryFields {

	const EXPECTED_PRIMARIES = [ 'group', 'id' ];

	public function __construct(

		public string $group,

		public string $id,

	) { }

}
