<?php

namespace Slendium\Ocd\Database;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
enum Feature {

	/**
	 * Indicates that any inserted or updated document of a collection must be valid according to
	 * that collection's schema.
	 *
	 * Any document with missing fields, extra fields, or invalid fields is rejected.
	 *
	 * @since 1.0
	 * @see Schema
	 */
	case SchemaEnforcement;

	/**
	 * Indicates that the primary field of a collection can be customized.
	 *
	 * If not supported, collections can only have one primary field and it will usually be stored
	 * under a specific name.
	 * Database implementations that don't support custom primaries may reject types with composite
	 * primary fields or primary fields not named 'id'.
	 *
	 * Stick to {@see Entity}'s for maximum compatibility.
	 *
	 * @since 1.0
	 * @see Schema\PrimaryFields
	 */
	case CustomPrimary;

	/**
	 * Indicates that documents can be automatically deleted based on one of its date fields.
	 * @since 1.0
	 * @see Schema\Constraint\ExpireAfter
	 */
	case ExpiringDocuments;

	/**
	 * Indicates that the database can enforce custom document invariants.
	 *
	 * Aka. `CHECK` constraints in SQL.
	 *
	 * @since 1.0
	 * @see Schema\Constraint\Invariant
	 */
	case DocumentInvariants;

	/**
	 * Indicates that the database can enforce relationships between collections.
	 *
	 * Aka. `FOREIGN KEY` constraints in SQL.
	 *
	 * @since 1.0
	 * @see Schema\Constraint\Reference
	 */
	case ReferenceEnforcement;

}
