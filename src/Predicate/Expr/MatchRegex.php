<?php

namespace Slendium\Ocd\Predicate\Expr;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate;

/**
 * Evaluates to `true` if the given field is a string that matches the given regular expression (PCRE).
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class MatchRegex implements Predicate {

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public FieldPath $field,

		/** @since 1.0 */
		public string $regex,

	) { }

}
