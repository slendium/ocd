<?php

namespace Slendium\Ocd\Predicate\Expr;

use Slendium\Ocd\Predicate;
use Slendium\Ocd\Predicate\FieldPath;

/**
 * Evaluates to `true` if the given field matches none of the values given exactly.
 *
 * Always evaluates to `true` if the field is an empty list, or if the field does not exist.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class MatchNone implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

		/**
		 * @since 1.0
		 * @var non-empty-list<string|float|int|bool|null>
		 */
		public iterable $values,

	) { }

}
