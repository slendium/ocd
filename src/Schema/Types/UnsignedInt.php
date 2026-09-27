<?php

namespace Slendium\Ocd\Schema\Types;

use Attribute;

use Slendium\Ocd\Schema\Type;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class UnsignedInt extends BaseInt implements Type\Unsigned {

	// TODO reject negative values

}
