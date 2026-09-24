<?php

namespace Slendium\Ocd\Schema\Types;

use Attribute;
use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class Map implements Type {

	/** @return array<mixed> */
	#[Override]
	public function serialize(mixed $value): array {
		throw new \Exception('Not implemented.');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): string {
		throw new \Exception('Not implemented.');
	}

}
