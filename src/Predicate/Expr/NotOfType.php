<?php

namespace Slendium\Ocd\Predicate\Expr;

use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate;
use Slendium\Ocd\Schema\StorageClass;

/**
 * Evaluates to `true` if a given field is not of a given type.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NotOfType implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

		/** @since 1.0 */
		public StorageClass $storageClass,

	) { }

	#[Override]
	public function accept(Predicate\Visitor $visitor): mixed {
		return $visitor->visitNotOfType($this);
	}

}
