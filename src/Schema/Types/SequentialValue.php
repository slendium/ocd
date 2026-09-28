<?php

namespace Slendium\Ocd\Schema\Types;

use Override;

use Slendium\Ocd\Entity\SequentialValue as SequentialValueValue;
use Slendium\Ocd\Schema\Type;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SequentialValue implements Type {

	private static self $instance;

	public static function instance(): self {
		return self::$instance ??= new self;
	}

	private function __construct() { }

	#[Override]
	public function serialize(mixed $input): SequentialValueValue {
		return SequentialValueValue::generate();
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): string {
		throw new \Exception('Not implemented');
	}

}
