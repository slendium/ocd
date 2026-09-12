<?php

namespace Slendium\Ocd\Predicate;

use Slendium\Ocd\Predicate\Expr;

/**
 * Visitor pattern that covers all predicate expressions an implementation should support.
 *
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
	public function visitAnd(Expr\And_ $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitOr(Expr\Or_ $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitExists(Expr\Exists $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitNotExists(Expr\NotExists $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitIsOfType(Expr\IsOfType $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitNotOfType(Expr\NotOfType $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitEqual(Expr\Equal $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitNotEqual(Expr\NotEqual $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitGreaterThan(Expr\GreaterThan $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitGreaterThanOrEqual(Expr\GreaterThanOrEqual $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitLessThan(Expr\LessThan $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitLessThanOrEqual(Expr\LessThanOrEqual $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMatchAll(Expr\MatchAll $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMatchSome(Expr\MatchSome $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMatchNone(Expr\MatchNone $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMatchRegex(Expr\MatchRegex $expr): mixed;

}
