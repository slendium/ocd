<?php

namespace Slendium\Ocd\Schema\Type;

/**
 * A type for which a size limit counted in bytes is applied to each value.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface ByteLimited {

	/**
	 * @since 1.0
	 * @var int<1,max>
	 */
	public int $byteLimit { get; }

}
