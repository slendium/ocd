<?php

namespace Slendium\Ocd\Schema\Type;

/**
 * A type for which each value has a fixed size in bytes, such as floating point numbers or integers.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Sized {

	/**
	 * @since 1.0
	 * @var int<1,max>
	 */
	public int $bytes { get; }

}
