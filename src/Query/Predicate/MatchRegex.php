<?php

namespace Slendium\Ocd\Query\Predicate;

use Override;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateVisitor;
use Slendium\Ocd\Query\ValuePath;

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
		public ValuePath $valueAt,

		/** @since 1.0 */
		public string $regex,

	) { }

	#[Override]
	public function accept(PredicateVisitor $visitor): mixed {
		return $visitor->visitMatchRegex($this);
	}

}
