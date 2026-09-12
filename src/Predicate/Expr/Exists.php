<?php

namespace Slendium\Ocd\Predicate\Expr;

use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate;

/**
 * Evaluates to `true` if the field exists in the object.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Exists implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

	) { }

	#[Override]
	public function accept(Predicate\Visitor $visitor): mixed {
		return $visitor->visitExists($this);
	}

}
