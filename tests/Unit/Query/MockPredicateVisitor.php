<?php

namespace Slendium\OcdTests\Unit\Query;

use Closure;
use InvalidArgumentException;
use Override;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateVisitor;

/**
 * @internal
 * @template R
 * @implements PredicateVisitor<R>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class MockPredicateVisitor implements PredicateVisitor {

	public function __construct(

		/** @var non-empty-array<non-empty-string,Closure(Predicate):R> */
		public array $hooks,

	) { }

	#[Override]
	public function visitAnd(Predicate\And_ $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitOr(Predicate\Or_ $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitExists(Predicate\Exists $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitNotExists(Predicate\NotExists $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitEqual(Predicate\Equal $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitNotEqual(Predicate\NotEqual $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitGreaterThan(Predicate\GreaterThan $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitGreaterThanOrEqual(Predicate\GreaterThanOrEqual $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitLessThan(Predicate\LessThan $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitLessThanOrEqual(Predicate\LessThanOrEqual $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitMatchAll(Predicate\MatchAll $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitMatchSome(Predicate\MatchSome $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitMatchNone(Predicate\MatchNone $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitMatchRegex(Predicate\MatchRegex $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	private function callHook(string $hook, Predicate $expr): mixed {
		$hook = $this->hooks[$hook]
			?? throw new InvalidArgumentException("Expected hook for `PredicateVisitor::$hook`");

		return $hook($expr);
	}

}
