<?php

namespace Slendium\Ocd\Entity;

use JsonSerializable;
use Stringable;

/**
 * A unique identifier for an object in a database collection.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Id extends JsonSerializable, Stringable {

	/**
	 * Contains the actual implementation-specific ID object.
	 *
	 * For example, this could be an `ObjectId` or `Guid`, but is most likely a string.
	 *
	 * @since 1.0
	 */
	public mixed $nativeId { get; }

}
