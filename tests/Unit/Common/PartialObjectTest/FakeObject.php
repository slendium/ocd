<?php

namespace Slendium\OcdTests\Unit\Common\PartialObjectTest;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class FakeObject {

	public function __construct(

		public int $a,

		public string $b,

		public bool $c,

	) { }

}
