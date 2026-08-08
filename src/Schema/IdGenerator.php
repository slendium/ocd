<?php

namespace Slendium\Ocd\Schema;

use Slendium\Ocd\Entity;

/**
 * Method to automatically generate an entity identifier.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
enum IdGenerator {

	/**
	 * Requires all documents to be inserted to have a pre-generated ID.
	 *
	 * This is also the value used for {@see Entity}'s that don't implement {@see Entity\Identifiable}.
	 * In this case an explicit value only needs to be provided if there is a regular field called "id".
	 *
	 * @since 1.0
	 */
	case None;

	/**
	 * Require the database to assign a sequential, automatically incremented number as an entity's
	 * ID, starting at 1.
	 * @since 1.0
	 */
	case Sequence;

	/**
	 * Require the database to assign a universally unique identifier using the optimal method for the
	 * database.
	 *
	 * Such as an `ObjectId` used by MongoDB or a GUID/UUID.
	 *
	 * @since 1.0
	 */
	case UniqueIdentifier;

}
