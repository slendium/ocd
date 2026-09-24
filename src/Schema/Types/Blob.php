<?php

namespace Slendium\Ocd\Schema\Types;

use Attribute;
use Override;

use Slendium\Ocd\Common\Blob as BlobValue;
use Slendium\Ocd\Schema\Type;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class Blob implements Type, Type\ByteLimited {

	/** @since 1.0 */
	const SIZE_64KB = 65_535;

	/** @since 1.0 */
	const SIZE_16MB = 16_777_215;

	/** @since 1.0 */
	const SIZE_4GB = 4_294_967_295;

	private static self $instance;

	/** @internal */
	public static function instance(): self {
		return self::$instance ??= new self;
	}

	/** @since 1.0 */
	public function __construct(

		/** @var int<1,max> */
		#[Override]
		public readonly int $byteLimit = self::SIZE_16MB,

	) { }

	#[Override]
	public function serialize(mixed $value): ?BlobValue {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): bool {
		throw new \Exception('Not implemented');
	}

}
