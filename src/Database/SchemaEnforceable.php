<?php

namespace Slendium\Ocd\Database;

use Slendium\Ocd\Schema;

/**
 * Offers support for enforcing a {@see Schema} on database collections.
 *
 * Try to avoid special characters in collection or field names.
 * Database implementations are allowed to reject schemas that contain names with characters that
 * would require escaping.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface SchemaEnforceable {

	/**
	 * Enforces the given schema for the given collection, creating one if it does not yet exist.
	 *
	 * {@see UpgradeOptions} can be used for more control over the behavior of the schema upgrade,
	 * such as which - if any - data losses to allow.
	 *
	 * @since 1.0
	 * @param non-empty-string $collection The name of the collection for which to enforce the schema
	 */
	public function enforceSchema(string $collection, Schema $schema): UpgradeCommand;

}
