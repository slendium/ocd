<?php

namespace Slendium\Ocd\Predicate\Expr;

use Slendium\Ocd\Predicate;
use Slendium\Ocd\Predicate\FieldPath;

/**
 * Evaluates to `true` if the field does not exist in the object.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NotExists implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

	) { }

}
