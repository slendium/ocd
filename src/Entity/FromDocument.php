<?php

namespace Slendium\Ocd\Entity;

use ArrayAccess;
use Countable;
use Traversable;

/**
 * Entity that can be created directly from documents, bypassing the need for schema evaluation.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface FromDocument {

	/**
	 * @since 1.0
	 * @param ArrayAccess<non-empty-string,mixed>&Countable&Traversable<non-empty-string,mixed> $doc
	 */
	public static function fromDocument(ArrayAccess&Countable&Traversable $doc): static;

}
