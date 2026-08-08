<?php

namespace Slendium\Ocd\Schema;

use Attribute;

/**
 * Marker to exclude a target from the schema.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class Exclude { }
