<?php

namespace Slendium\Ocd\Predicate\Expr;

use BackedEnum;
use DateTimeInterface;
use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate;

/**
 * Evaluates to `true` if the field matches all the given values exactly.
 *
 * Always evaluates to `false` if the field is an empty list or if the field does not exist.
 *
 * If the field is not a list, the predicate can only evaluate to `true` if the list of values contains
 * a single element which has the same value as the field.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class MatchAll implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

		/**
		 * @since 1.0
		 * @var non-empty-list<DateTimeInterface|BackedEnum|string|float|int|bool|null>
		 */
		public array $values,

	) { }

	#[Override]
	public function accept(Predicate\Visitor $visitor): mixed {
		return $visitor->visitMatchAll($this);
	}

}
