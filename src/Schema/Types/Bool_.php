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
final class Bool_ implements Type, Type\DefaultSerializable {

	/** @since 1.0 */
	const false SERIALIZE_DEFAULT = false;

	private static self $instance;

	/** @since 1.0 */
	public static function instance(): self {
		return self::$instance ??= new self;
	}

	#[Override]
	public function serialize(mixed $value): bool {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function deserialize(mixed $stored): bool {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function isDefaultSerializeValue(mixed $value): bool {
		return $value === self::SERIALIZE_DEFAULT;
	}

	#[Override]
	public function getDefaultSerializeValue(): bool {
		return self::SERIALIZE_DEFAULT;
	}

}
