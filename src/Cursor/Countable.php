<?php

namespace Slendium\Ocd\Cursor;

/**
 * Allows counting the total documents available to the cursor-like object as if no paging limits were applied.
 *
 * When combined with {@see Filterable}, the filter should be applied before returning the total count.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Countable {

	/**
	 * Queries the total document count as if no paging limits were applied.
	 *
	 * The returned count is allowed to be a reasonable estimate.
	 *
	 * @since 1.0
	 * @return int<0,max>
	 */
	public function queryCount(): int;

}
