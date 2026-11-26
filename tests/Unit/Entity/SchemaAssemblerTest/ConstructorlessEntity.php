<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class ConstructorlessEntity implements Entity {

	const string FIXED_ID = '478f718b-ec25-490a-b0e2-7573f0f3dea9';

	#[Override]
	public string $id {
		get => self::FIXED_ID;
	}

}
