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
		 * Indicates whether to allow any kind of data loss from a schema upgrade.
		 *
		 * This applies to both truncation of existing data and dropping whole columns.
		 *
		 * Trunction only needs to be considered for fields with a database-enforced maximum length.
		 * Strings in schemaless databases or inside JSON structures usually don't have an enforced maximum length.
		 * When set to `false`, implementations should keep the field size at the existing (larger) size,
		 * but any other modifications to the field should still be applied.
		 *
		 * The intended use of this option is to allow an upgrade in stages:
		 *
		 * 1. Run the schema upgrade without data losses, adding new columns and tables.
		 * 2. Convert and move existing data into the new columns and tables.
		 * 3. Rerun the schema upgrade, now with data losses allowed, to clean up unused columns and tables.
		 *
		 * @since 1.0
		 */
		public bool $allowLoss = false,

	) { }

}
