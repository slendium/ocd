<?php

namespace Slendium\Ocd\Schema;

use Attribute;
use Closure;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class IdOptions {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public IdGenerator $generator,

	) { }

}
