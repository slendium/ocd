<?php

namespace Slendium\Ocd\Entity;

use Slendium\Ocd\Schema;

/**
 * An object that can be uniquely identified in a database collection.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Identifiable {

	/** @since 1.0 */
	public Id $id { get; }

}
