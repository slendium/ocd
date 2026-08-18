<?php

namespace Slendium\Ocd\Predicate\Expr;

use Slendium\Ocd\Predicate;

/**
 * Evaluates to `true` if all inputs evaluate to `true`.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class And_ implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-list<Predicate>
		 */
		public array $inputs,

	) { }

}
