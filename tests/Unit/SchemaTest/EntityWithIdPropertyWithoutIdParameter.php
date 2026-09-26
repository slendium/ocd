<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class EntityWithIdPropertyWithoutIdParameter implements Entity {

	#[Override]
	public string $id = '';

	public function __construct() { }

}
