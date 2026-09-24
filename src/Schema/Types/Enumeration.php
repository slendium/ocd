<?php

namespace Slendium\Ocd\Schema\Types;

use Attribute;
use BackedEnum;
use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class Enumeration implements Type {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var class-string<BackedEnum>
		 */
		public readonly string $backedEnumClass,

	) { }

	#[Override]
	public function serialize(mixed $value): BackedEnum {
		throw new \Exception('Not implemented.');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): string {
		throw new \Exception('Not implemented.');
	}

}
