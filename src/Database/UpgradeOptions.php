<?php

namespace Slendium\Ocd\Database;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UpgradeOptions {

	/** @since 1.0 */
	public function __construct(

		/**
		 * Indicates whether to allow truncation of values in existing fields (eg. reducing the size
		 * of a string or int field).
		 *
		 * This only applies to truncatable fields, ie. to fields that have a max. length enforced by the database.
		 * Strings in schemaless databases or inside JSON structures usually don't have an enforced max. length.
		 *
		 * Implementations should ignore truncations when set to `false`, ie. keep the field at the
		 * existing (larger) size.
		 * A notice should be emitted about data that can be truncated.
		 *
		 * @since 1.0
		 */
		public bool $allowTruncate = false,

		/**
		 * Indicates wether to allow dropping whole columns or tables.
		 *
		 * Implementations should just keep the data when set to `false`.
		 * A notice should be emitted about data that can be dropped.
		 *
		 * @since 1.0
		 */
		public bool $allowDrop = false,

	) { }

}
