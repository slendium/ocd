<?php

namespace Slendium\Ocd\Update\Stmt;

use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Update;

/**
 * Sets a new value for the given field.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Set implements Update {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

		/** @since 1.0 */
		public string|float|int|bool|null $value,

	) { }

	#[Override]
	public function accept(Update\Visitor $visitor): mixed {
		return $visitor->visitSet($this);
	}

}
