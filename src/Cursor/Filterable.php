<?php

namespace Slendium\Ocd\Cursor;

use Slendium\Ocd\Query\Predicate;

/**
 * Allows adding a filter to a cursor-like object.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Filterable {

	/** @since 1.0 */
	public ?Predicate $filter { get; set; }

}
