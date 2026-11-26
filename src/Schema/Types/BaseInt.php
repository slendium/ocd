<?php

namespace Slendium\Ocd\Schema\Types;

use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
abstract class BaseInt implements Type, Type\Sized, Type\DefaultSerializable {

	/** @since 1.0 */
	const int SIZE_INT8 = 1;

	/** @since 1.0 */
	const int SIZE_INT16 = 2;

	/** @since 1.0 */
	const int SIZE_INT32 = 4;

	/** @since 1.0 */
	const int SIZE_INT64 = 8;

	/** @since 1.0 */
	const int SERIALIZE_DEFAULT = 0;

	/** @since 1.0 */
	public function __construct(

		/** @var int<1,max> */
		#[Override]
		public readonly int $bytes = self::SIZE_INT32,

	) { }

	#[Override]
	public function serialize(mixed $value): int {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function deserialize(mixed $stored): int {
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
