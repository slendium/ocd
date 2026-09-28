<?php

namespace Slendium\Ocd\Query;

/**
 * @since 1.0
 * @template R
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface UpdateVisitor {

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitAdd(Update\Add $stmt): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitAppend(Update\Append $stmt): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMultiply(Update\Multiply $stmt): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitSet(Update\Set $stmt): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitUnset(Update\Unset_ $stmt): mixed;

}
