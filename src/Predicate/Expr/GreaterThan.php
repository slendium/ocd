<?php

namespace Slendium\Ocd\Predicate\Expr;

use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate;

/**
 * Evaluates to `true` if the left-hand-side is greater than the right-hand-side.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class GreaterThan implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath|float|int $lhs,

		/** @since 1.0 */
		public FieldPath|float|int $rhs,

	) { }

	#[Override]
	public function accept(Predicate\Visitor $visitor): mixed {
		return $visitor->visitGreaterThan($this);
	}

}
