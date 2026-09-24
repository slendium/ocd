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
final class String_ implements Type, Type\CharacterLimited {

	/** @since 1.0 */
	const DEFAULT_CHARACTER_LIMIT = 150;

	private static self $instance;

	/** @internal */
	public static function instance(): self {
		return self::$instance ??= new self;
	}

	/** @since 1.0 */
	public function __construct(

		/** @var int<1,max> */
		#[Override]
		public readonly int $characterLimit = self::DEFAULT_CHARACTER_LIMIT,

	) { }

	#[Override]
	public function serialize(mixed $value): ?string {
		throw new \Exception('Not implemented.');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): string {
		throw new \Exception('Not implemented');
	}

}
