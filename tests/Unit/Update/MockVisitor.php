<?php

namespace Slendium\OcdTests\Unit\Update;

use Closure;
use InvalidArgumentException;
use Override;

use Slendium\Ocd\Update;
use Slendium\Ocd\Update\Stmt;
use Slendium\Ocd\Update\Visitor;

/**
 * @internal
 * @template R
 * @implements Visitor<R>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class MockVisitor implements Visitor {

	public function __construct(

		/** @var non-empty-array<non-empty-string,Closure(Update):R> */
		public array $hooks,

	) { }

	#[Override]
	public function visitAdd(Stmt\Add $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	#[Override]
	public function visitAppend(Stmt\Append $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	#[Override]
	public function visitMultiply(Stmt\Multiply $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	#[Override]
	public function visitSet(Stmt\Set $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	#[Override]
	public function visitUnset(Stmt\Unset_ $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	private function callHook(string $hook, Update $stmt): mixed {
		$hook = $this->hooks[$hook]
			?? throw new InvalidArgumentException("Expected hook for `Visitor::$hook`");

		return $hook($stmt);
	}

}
