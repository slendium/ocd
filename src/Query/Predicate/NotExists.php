<?php

namespace Slendium\Ocd\Query\Predicate;

use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateVisitor;

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

	#[Override]
	public function accept(PredicateVisitor $visitor): mixed {
		return $visitor->visitNotExists($this);
	}

}
