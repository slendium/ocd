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
final class Map implements Type, Type\DefaultSerializable {

	/** @since 1.0 */
	const array SERIALIZE_DEFAULT = [ ];

	/** @return array<mixed> */
	#[Override]
	public function serialize(mixed $value): array {
		throw new \Exception('Not implemented.');
	}

	/** @return array<mixed> */
	#[Override]
	public function deserialize(mixed $stored): array {
		throw new \Exception('Not implemented.');
	}

	#[Override]
	public function isDefaultSerializeValue(mixed $value): bool {
		return \is_array($value) && empty($value);
	}

	/** @return array<mixed> */
	#[Override]
	public function getDefaultSerializeValue(): array {
		return self::SERIALIZE_DEFAULT;
	}

}
