<?php

namespace Slendium\Ocd\Schema\Type;

/**
 * A type for which a character limit is applied to each value.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface CharacterLimited {

	/**
	 * @since 1.0
	 * @var int<1,max>
	 */
	public int $characterLimit { get; }

}
