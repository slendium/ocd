<?php

namespace Slendium\Ocd\Schema\Field;

use Attribute;

use Slendium\Ocd\Common\MarkerAttribute;

/**
 * Marks a single field as indexed.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class Indexed {

	use MarkerAttribute;

}
