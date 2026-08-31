<?php

namespace Slendium\Ocd\Collection;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class WriteOptions {

	/** @since 1.0 */
	public function __construct(

		/**
		 * The desired level of write acknowledgment.
		 *
		 * Use `null` to use the level recommended by the database.
		 *
		 * @since 1.0
		 */
		public ?WriteAcknowledgment $acknowledgment = null,

	) { }

}
