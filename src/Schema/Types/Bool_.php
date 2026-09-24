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
final class Bool_ implements Type {

	private static self $instance;

	/** @internal */
	public static function instance(): self {
		return self::$instance ??= new self;
	}

	/** @since 1.0 */
	public function __construct() { }

	#[Override]
	public function serialize(mixed $value): ?bool {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): bool {
		throw new \Exception('Not implemented');
	}

}
