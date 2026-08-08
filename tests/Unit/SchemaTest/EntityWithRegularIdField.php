<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithRegularIdField implements Entity {

	public function __construct(public string $id) { }

}
