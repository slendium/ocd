<?php

namespace Slendium\Ocd\Entity;

use ArrayAccess;
use Countable;
use Traversable;

/**
 * Assembles entities from documents.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Assembler {

	/**
	 * Attempts to assemble an entity of the given type from the given document.
	 *
	 * See issue #116 for the progress on partials.
	 * Currently assumes the document passed is a full document where any missing fields have a `null` value.
	 *
	 * @since 1.0
	 * @template T of object
	 * @param ArrayAccess<non-empty-string,mixed>&Countable&Traversable<non-empty-string,mixed> $doc
	 * @param class-string<T> $type
	 * @return T
	 */
	public function assemble(ArrayAccess&Countable&Traversable $doc, string $type): object;

}
