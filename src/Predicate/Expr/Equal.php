<?php

namespace Slendium\Ocd\Predicate\Expr;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate;

/**
 * Evaluates to `true` if both sides are equal to each other, both in type and value.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Equal implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath|string|float|int|bool|null $lhs,

		/** @since 1.0 */
		public FieldPath|string|float|int|bool|null $rhs,

	) { }

}
