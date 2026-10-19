<?php

namespace Slendium\Ocd\Schema\Field;

use Attribute;

use Slendium\Ocd\Common\MarkerAttribute;
use Slendium\Ocd\Schema\Constraint\ConstraintAction;

/**
 * Overrides the default options of an implied field reference.
 *
 * For example, the following entity has a field `$category` which is an implied reference to another
 * database object defined by the `Category` class.
 *
 * ```php
 * final readonly class Article implements Entity {
 *
 * 	public function __construct(
 *
 * 		#[Override]
 * 		public Entity\UniqueIdentifier $id,
 *
 * 		#[Reference(onDelete: ConstraintAction::SetNull)]
 * 		public ?Category $category,
 *
 * 	) { }
 *
 * }
 * ```
 *
 * This implies a {@see \Slendium\Ocd\Schema\Constraint\Reference} constraint on the schema created
 * for `Article`s that maps to the primary field of the `Category`.
 * In the example the `onDelete` {@see ConstraintAction} is overridden to set `$category` to `null`
 * whenever the referenced category is deleted.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class Reference {

	use MarkerAttribute;

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public ConstraintAction $onUpdate = ConstraintAction::Cascade,

		/** @since 1.0 */
		public ConstraintAction $onDelete = ConstraintAction::Restrict,

	) { }

}
