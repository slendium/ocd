<?php

namespace Slendium\Ocd\Query\Predicate;

use Override;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateAggregate;
use Slendium\Ocd\Query\PredicateVisitor;

/**
 * Evaluates to `true` if all inputs evaluate to `true`.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class And_ implements PredicateAggregate {

	/** @since 1.0 */
	public function __construct(

		/** @var non-empty-list<Predicate> */
		#[Override]
		public array $inputs,

	) { }

	#[Override]
	public function accept(PredicateVisitor $visitor): mixed {
		return $visitor->visitAnd($this);
	}

}
