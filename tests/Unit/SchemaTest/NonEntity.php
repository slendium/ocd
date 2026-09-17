<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NonEntity {

	public function __construct(

		public string $name,

		public float $factor,

		public int $count,

		public bool $flag,

	) { }

}
