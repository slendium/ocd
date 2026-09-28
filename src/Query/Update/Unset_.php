<?php

namespace Slendium\Ocd\Query\Update;

use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Query\Update;
use Slendium\Ocd\Query\UpdateVisitor;

/**
 * Unsets a field.
 *
 * Where possible this operation will remove the field entirely.
 * If it is a top-level field in an SQL-based database, the field will be set to the default value.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Unset_ implements Update {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

	) { }

	#[Override]
	public function accept(UpdateVisitor $visitor): mixed {
		return $visitor->visitUnset($this);
	}

}
