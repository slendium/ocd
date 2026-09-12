<?php

namespace Slendium\Ocd\Common;

/**
 * Wrapper to distinguish a text string from a binary blob.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Blob {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public string $bytes,

	) { }

}
