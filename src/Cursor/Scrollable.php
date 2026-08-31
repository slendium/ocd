<?php

namespace Slendium\Ocd\Cursor;

/**
 * Allows the resulting document set to be scrolled before being returned.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Scrollable {

	/**
	 * The amount of documents to skip before returning results.
	 *
	 * This value is often called the `OFFSET` in SQL languages.
	 *
	 * @since 1.0
	 * @var int<0,max>
	 */
	public int $skip { get; set; }

	/**
	 * The amount of documents that should be returned.
	 *
	 * A value of `0` indicates "no limits."
	 *
	 * @since 1.0
	 * @var int<0,max>
	 */
	public int $limit { get; set; }

}
