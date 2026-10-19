<?php

namespace Slendium\Ocd\Schema\Constraint;

use Attribute;

use Slendium\Ocd\Schema\Constraint;

/**
 * Indicates that a document should be deleted when a given field's value is in the past.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_CLASS)]
final readonly class ExpireAfter implements Constraint {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-string
		 */
		public string $field,

	) { }

}
