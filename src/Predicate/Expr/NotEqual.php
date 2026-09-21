<?php

namespace Slendium\Ocd\Predicate\Expr;

use BackedEnum;
use DateTimeInterface;
use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate;

/**
 * Evaluates to `true` if both sides are not equal to each other, both in type and value.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NotEqual implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath|DateTimeInterface|BackedEnum|string|float|int|bool|null $lhs,

		/** @since 1.0 */
		public FieldPath|DateTimeInterface|BackedEnum|string|float|int|bool|null $rhs,

	) { }

	#[Override]
	public function accept(Predicate\Visitor $visitor): mixed {
		return $visitor->visitNotEqual($this);
	}

}
