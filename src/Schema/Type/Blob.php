<?php

namespace Slendium\Ocd\Schema\Type;

use Override;

use Slendium\Ocd\Common\Blob as BlobValue;
use Slendium\Ocd\Schema\Type;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Blob implements Type {

	private static self $instance;

	public static function instance(): self {
		return self::$instance ??= new self;
	}

	private function __construct() { }

	#[Override]
	public function serialize(mixed $value): ?BlobValue {
		throw new \Exception('Not implemented');
	}

	#[Override]
	public function deserialize(object|iterable|string|float|int|bool|null $stored): bool {
		throw new \Exception('Not implemented');
	}

}
