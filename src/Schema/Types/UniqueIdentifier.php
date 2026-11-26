<?php

namespace Slendium\Ocd\Schema\Types;

use Override;

use Slendium\Ocd\Entity\UniqueIdentifier as UniqueIdentifierValue;
use Slendium\Ocd\Schema\Type;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UniqueIdentifier implements Type {

	private static self $instance;

	public static function instance(): self {
		return self::$instance ??= new self;
	}

	private function __construct() { }

	#[Override]
	public function serialize(mixed $input): UniqueIdentifierValue {
		return UniqueIdentifierValue::generate();
	}

	#[Override]
	public function deserialize(mixed $stored): UniqueIdentifierValue {
		throw new \Exception('Not implemented');
	}

}
