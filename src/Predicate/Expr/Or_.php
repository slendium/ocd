<?php

namespace Slendium\Ocd\Predicate\Expr;

use Override;

use Slendium\Ocd\Predicate;

/**
 * Evaluates to `true` if at least one input evaluates to `true`.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Or_ implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-list<Predicate>
		 */
		public array $inputs,

	) { }

	#[Override]
	public function accept(Predicate\Visitor $visitor): mixed {
		return $visitor->visitOr($this);
	}

}
