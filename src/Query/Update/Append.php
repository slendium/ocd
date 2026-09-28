<?php

namespace Slendium\Ocd\Query\Update;

use Override;

use Slendium\Ocd\Common\Blob;
use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Query\Update;
use Slendium\Ocd\Query\UpdateVisitor;

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
		public mixed $value,

	) { }

	#[Override]
	public function accept(UpdateVisitor $visitor): mixed {
		return $visitor->visitAppend($this);
	}

}
