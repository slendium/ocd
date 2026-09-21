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
class ErrorableStringType implements Type {

	#[Override]
	public function serialize(mixed $value): Type\SerializeException|string {
		throw new Exception('Not implemented');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): mixed {
		throw new Exception('Not implemented');
	}

}
