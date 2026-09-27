<?php

namespace Slendium\Ocd\Schema\Types;

use Attribute;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class Float_ extends BaseFloat {

	private static self $instance;

	/** @internal */
	public static function instance(): self {
		return self::$instance ??= new self;
	}

}
