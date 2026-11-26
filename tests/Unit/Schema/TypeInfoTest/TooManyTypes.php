<?php

namespace Slendium\OcdTests\Unit\Schema\TypeInfoTest;

use Exception;
use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class TooManyTypes implements Type {

	#[Override]
	public function serialize(mixed $value): Type\SerializeException|string|float|int {
		throw new Exception('Not implemented');
	}

	#[Override]
	public function deserialize(mixed $stored): mixed {
		throw new Exception('Not implemented');
	}

}
