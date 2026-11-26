<?php

namespace Slendium\OcdTests\Common;

use Closure;

/**
 * @internal
 * @template T of string = string
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class MockStringable {

	public function __construct(

		/** @var (Closure():T)|T */
		private Closure|string $toString,

	) { }

	/** @return T */
	public function __toString(): string {
		return \is_string($this->toString)
			? $this->toString
			: ($this->toString)();
	}

}
