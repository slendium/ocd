<?php

namespace Slendium\OcdTests\Unit\Predicate;

use Closure;
use InvalidArgumentException;
use Override;

use Slendium\Ocd\Predicate;
use Slendium\Ocd\Predicate\Expr;
use Slendium\Ocd\Predicate\Visitor;

/**
 * @internal
 * @template R
 * @implements Visitor<R>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class MockVisitor implements Visitor {

	public function __construct(

		/** @var non-empty-array<non-empty-string,Closure(Predicate):R> */
		public array $hooks,

	) { }

	#[Override]
	public function visitAnd(Expr\And_ $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitOr(Expr\Or_ $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitExists(Expr\Exists $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitNotExists(Expr\NotExists $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitEqual(Expr\Equal $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitNotEqual(Expr\NotEqual $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitGreaterThan(Expr\GreaterThan $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitGreaterThanOrEqual(Expr\GreaterThanOrEqual $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitLessThan(Expr\LessThan $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitLessThanOrEqual(Expr\LessThanOrEqual $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitMatchAll(Expr\MatchAll $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitMatchSome(Expr\MatchSome $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitMatchNone(Expr\MatchNone $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	#[Override]
	public function visitMatchRegex(Expr\MatchRegex $expr): mixed {
		return $this->callHook(__FUNCTION__, $expr);
	}

	private function callHook(string $hook, Predicate $expr): mixed {
		$hook = $this->hooks[$hook]
			?? throw new InvalidArgumentException("Expected hook for `Visitor::$hook`");

		return $hook($expr);
	}

}
