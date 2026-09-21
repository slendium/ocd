<?php

namespace Slendium\Ocd\Schema\Types;

use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Map implements Type {

	// TODO: key/value type enforcement

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
