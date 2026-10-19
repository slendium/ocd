<?php

namespace Slendium\Ocd\Schema\Constraint;

use Attribute;

use Slendium\Ocd\Schema\Constraint;

/**
 * Indicates a (combination of) field(s) that must have a unique value within the collection.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Unique implements Constraint {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-list<non-empty-string>
		 */
		public array $fields,

	) { }

}
