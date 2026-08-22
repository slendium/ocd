<?php

namespace Slendium\Ocd\Update\Stmt;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Update;

/**
 * Appends a list/array field with a given literal value.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Append implements Update {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

		/** @since 1.0 */
		public string|float|int|bool|null $value,

	) { }

}
