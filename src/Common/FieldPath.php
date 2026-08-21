<?php

namespace Slendium\Ocd\Common;

/**
 * A path to a field.
 *
 * A path with only one entry refers to a top-level field.
 * A path with more than one entry refers to a field inside a nested document or JSON structure.
 * MongoDB does not distinguish between the two cases, but in SQL databases the latter will trigger
 * a query involving a JSON path consisting of the entries past the first one.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class FieldPath {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-list<non-empty-string>
		 */
		public array $path,

	) { }

}
