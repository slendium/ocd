<?php

namespace Slendium\Ocd\Query;

/**
 * An aggregate of one or more predicates.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface PredicateAggregate extends Predicate {

	/**
	 * @since 1.0
	 * @var non-empty-list<Predicate>
	 */
	public array $inputs { get; }

}
