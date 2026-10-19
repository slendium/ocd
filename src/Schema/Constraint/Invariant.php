<?php

namespace Slendium\Ocd\Schema\Constraint;

use Attribute;
use Closure;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Schema\Constraint;

/**
 * A condition that must hold for every document in the collection.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Invariant implements Constraint {

	/** @since 1.0 */
	public Predicate $condition;

	/**
	 * @since 1.0
	 * @param (Closure():Predicate)|Predicate $condition
	 */
	public function __construct(Closure|Predicate $condition) {
		$this->condition = $condition instanceof Closure
			? $condition()
			: $condition;
	}

}
