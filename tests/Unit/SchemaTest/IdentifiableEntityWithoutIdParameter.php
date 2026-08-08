<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class IdentifiableEntityWithoutIdParameter implements Entity, Entity\Identifiable {

	#[Override]
	public Entity\Id $id;

}
