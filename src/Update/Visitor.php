<?php

namespace Slendium\Ocd\Update;

/**
 * @since 1.0
 * @template R
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Visitor {

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitAdd(Stmt\Add $stmt): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitAppend(Stmt\Append $stmt): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMultiply(Stmt\Multiply $stmt): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitSet(Stmt\Set $stmt): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitUnset(Stmt\Unset_ $stmt): mixed;

}
