<?php

namespace Slendium\Ocd\Schema\Field;

use Attribute;

use Slendium\Ocd\Common\MarkerAttribute;

/**
 * Marks a field as unique.
 *
 * This is essentially a shorthand for declaring a single-field {@see \Slendium\Ocd\Schema\Constraint\Unique}
 * constraint.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class Unique {

	use MarkerAttribute;

}
