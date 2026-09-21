<?php

namespace Slendium\Ocd\Schema\Types;

use DateTime;
use Override;

use Slendium\Ocd\Schema\Type;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DateTimeMutable implements Type {

	private static self $instance;

	public static function instance(): self {
		return self::$instance ??= new self;
	}

	#[Override]
	public function serialize(mixed $value): DateTime {
		throw new \Exception('Not implemented.');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): string {
		throw new \Exception('Not implemented.');
	}

}
