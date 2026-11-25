<?php

namespace Slendium\Ocd\Query;

/**
 * Specifies the (relative) path to a value inside a document.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class ValuePath {

	/** @since 1.0 */
	public function __construct(

		/**
		 * The path to a top level field.
		 *
		 * Each field name in the path is assumed to be a reference to another collection, except
		 * the last one.
		 *
		 * @since 1.0
		 * @var non-empty-list<non-empty-string>
		 */
		public array $fieldPath,

		/**
		 * The path to a value inside the field specified by the field path.
		 * @since 1.0
		 * @var list<string>
		 */
		public array $innerPath = [ ],

	) { }

}
