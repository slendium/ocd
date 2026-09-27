<?php

namespace Slendium\Ocd\Entity;

/**
 * An entity that can be constructed from a static constructor method called `fromFields()`.
 *
 * The parameters of the static constructor method override those of the regular constructor when
 * creating a {@see \Slendium\Ocd\Schema}.
 *
 * This interface can be used to return different subclasses of the entity based on a database field
 * or to free up the regular constructor (eg. for a variadic parameter).
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface FromFields {

	// Imagine that a method like this exists on all implementations
	// public static function fromFields(): static;

}
