<?php

namespace Slendium\Ocd\Query;

/**
 * Visitor pattern that covers all predicate expressions an implementation should support.
 *
 * @since 1.0
 * @template R
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface PredicateVisitor {

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitAnd(Predicate\And_ $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitOr(Predicate\Or_ $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitExists(Predicate\Exists $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitNotExists(Predicate\NotExists $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitEqual(Predicate\Equal $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitNotEqual(Predicate\NotEqual $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitGreaterThan(Predicate\GreaterThan $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitGreaterThanOrEqual(Predicate\GreaterThanOrEqual $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitLessThan(Predicate\LessThan $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitLessThanOrEqual(Predicate\LessThanOrEqual $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMatchAll(Predicate\MatchAll $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMatchSome(Predicate\MatchSome $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMatchNone(Predicate\MatchNone $expr): mixed;

	/**
	 * @since 1.0
	 * @return R
	 */
	public function visitMatchRegex(Predicate\MatchRegex $expr): mixed;

}
