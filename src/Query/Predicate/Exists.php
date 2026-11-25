<?php

namespace Slendium\Ocd\Query\Predicate;

use Override;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateVisitor;
use Slendium\Ocd\Query\ValuePath;

/**
 * Evaluates to `true` if the field exists in the object.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Exists implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public ValuePath $path,

	) { }

	#[Override]
	public function accept(PredicateVisitor $visitor): mixed {
		return $visitor->visitExists($this);
	}

}
