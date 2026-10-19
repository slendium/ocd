<?php

namespace Slendium\OcdTests\Common\Entities;

use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Schema\PrimaryFields(self::PRIMARY)]
final readonly class ObjectWithCompositePrimary {

	const PRIMARY = [ 'group', 'order' ];

	public function __construct(

		public string $group,

		public int $order,

	) { }

}
