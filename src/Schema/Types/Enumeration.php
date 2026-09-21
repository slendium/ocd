<?php

namespace Slendium\Ocd\Schema\Types;

use BackedEnum;
use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Enumeration implements Type {

	// TODO: limit each instance to a specific BackedEnum type and reuse these instances

	#[Override]
	public function serialize(mixed $value): BackedEnum {
		throw new \Exception('Not implemented.');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): string {
		throw new \Exception('Not implemented.');
	}

}
