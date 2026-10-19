<?php

namespace Slendium\Ocd\Schema;

use Attribute;

/**
 * A plain index without any constraints.
 *
 * See {@see Constraint\Unique} to create unique fields.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Index {

	/** @since 1.0 */
	public function __construct(

		/**
		 * The names of the fields that form the index.
		 * @since 1.0
		 * @var non-empty-list<non-empty-string>
		 */
		public array $fields,

	) { }

}
