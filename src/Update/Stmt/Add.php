<?php

namespace Slendium\Ocd\Update\Stmt;

use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Update;

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
		public FieldPath $field,

		/** @since 1.0 */
		public float|int $amount,

	) { }

	#[Override]
	public function accept(Update\Visitor $visitor): mixed {
		return $visitor->visitAdd($this);
	}

}
