<?php

namespace Slendium\OcdTests\Unit\Query;

use Closure;
use InvalidArgumentException;
use Override;

use Slendium\Ocd\Query\Update;
use Slendium\Ocd\Query\UpdateVisitor;

/**
 * @internal
 * @template R
 * @implements UpdateVisitor<R>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class MockUpdateVisitor implements UpdateVisitor {

	public function __construct(

		/** @var non-empty-array<non-empty-string,Closure(Update):R> */
		public array $hooks,

	) { }

	#[Override]
	public function visitAdd(Update\Add $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	#[Override]
	public function visitAppend(Update\Append $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	#[Override]
	public function visitMultiply(Update\Multiply $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	#[Override]
	public function visitSet(Update\Set $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	#[Override]
	public function visitUnset(Update\Unset_ $stmt): mixed {
		return $this->callHook(__FUNCTION__, $stmt);
	}

	private function callHook(string $hook, Update $stmt): mixed {
		$hook = $this->hooks[$hook]
			?? throw new InvalidArgumentException("Expected hook for `UpdateVisitor::$hook`");

		return $hook($stmt);
	}

}
