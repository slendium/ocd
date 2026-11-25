<?php

namespace Slendium\Ocd\Query\Update;

use Override;

use Slendium\Ocd\Query\Update;
use Slendium\Ocd\Query\UpdateVisitor;
use Slendium\Ocd\Query\ValuePath;

/**
 * Adds a given amount to the value of the field.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Add implements Update {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public ValuePath $path,

		/** @since 1.0 */
		public float|int $amount,

	) { }

	#[Override]
	public function accept(UpdateVisitor $visitor): mixed {
		return $visitor->visitAdd($this);
	}

}
