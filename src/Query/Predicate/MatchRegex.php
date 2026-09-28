<?php

namespace Slendium\Ocd\Query\Predicate;

use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateVisitor;

/**
 * Evaluates to `true` if the given field is a string that matches the given regular expression (PCRE).
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class MatchRegex implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

		/** @since 1.0 */
		public string $regex,

	) { }

	#[Override]
	public function accept(PredicateVisitor $visitor): mixed {
		return $visitor->visitMatchRegex($this);
	}

}
