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
final class Float_ implements Type, Type\Sized {

	/** @since 1.0 */
	const SIZE_FLOAT32 = 4;

	/** @since 1.0 */
	const SIZE_FLOAT64 = 8;

	private static self $instance;

	/** @internal */
	public static function instance(): self {
		return self::$instance ??= new self;
	}

	/** @since 1.0 */
	public function __construct(

		/** @var int<1,max> */
		#[Override]
		public readonly int $bytes = self::SIZE_FLOAT32,

	) { }

	#[Override]
	public function serialize(mixed $value): ?float {
		// test for `\is_finite($value)` too (checks against both NAN and INF)

		throw new \Exception('Not implemented');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): float {
		throw new \Exception('Not implemented');
	}

}
