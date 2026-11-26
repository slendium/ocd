<?php

namespace Slendium\Ocd\Schema\Types;

use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
abstract class BaseFloat implements Type, Type\Sized, Type\DefaultSerializable {

	/** @since 1.0 */
	const int SIZE_FLOAT32 = 4;

	/** @since 1.0 */
	const int SIZE_FLOAT64 = 8;

	/** @since 1.0 */
	const float SERIALIZE_DEFAULT = 0.0;

	/** @since 1.0 */
	public function __construct(

		/** @var int<1,max> */
		#[Override]
		public readonly int $bytes = self::SIZE_FLOAT32,

	) { }

	#[Override]
	public function serialize(mixed $value): float {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function deserialize(mixed $stored): float {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function isDefaultSerializeValue(mixed $value): bool {
		return $value === self::SERIALIZE_DEFAULT;
	}

	#[Override]
	public function getDefaultSerializeValue(): float {
		return self::SERIALIZE_DEFAULT;
	}

}
