<?php

namespace Slendium\Ocd\Schema\Types;

use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
abstract class BaseFloat implements Type, Type\Sized {

	/** @since 1.0 */
	const SIZE_FLOAT32 = 4;

	/** @since 1.0 */
	const SIZE_FLOAT64 = 8;

	/** @since 1.0 */
	public function __construct(

		/** @var int<1,max> */
		#[Override]
		public readonly int $bytes = self::SIZE_FLOAT32,

	) { }

	#[Override]
	public function serialize(mixed $value): ?float {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): float {
		throw new \Exception('Not implemented');
	}

}
