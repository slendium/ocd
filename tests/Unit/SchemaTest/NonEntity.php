<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class NonEntity implements Entity\Identifiable {

	#[Override]
	public readonly Entity\Id $id;

	public string $name;

	public int $counter;

	public function __construct(Entity\Id $id, string $name, int $counter) {
		$this->id = $id;
		$this->name = $name;
		$this->counter = $counter;
	}

}
