<?php

namespace Slendium\Ocd\Query\Predicate;

use BackedEnum;
use DateTimeInterface;
use Override;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateVisitor;
use Slendium\Ocd\Query\ValuePath;

/**
 * Evaluates to `true` if the given field matches at least one of the given values exactly.
 *
 * Always evaluates to `false` if the field is an empty list or if the field does not exist.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class MatchSome implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public ValuePath $valueAt,

		/**
		 * @since 1.0
		 * @var non-empty-list<DateTimeInterface|BackedEnum|string|float|int|bool|null>
		 */
		public array $values,

	) { }

	#[Override]
	public function accept(PredicateVisitor $visitor): mixed {
		return $visitor->visitMatchSome($this);
	}

}
