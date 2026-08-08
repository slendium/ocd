<?php

namespace Slendium\Ocd\Schema;

use Attribute;

/**
 * Contains the preferred name of field.
 *
 * For maximum compatibility: keep field names simple and avoid special characters, especially `.` and `$`.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class FieldName {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-string
		 */
		public string $name,

	) { }

}
