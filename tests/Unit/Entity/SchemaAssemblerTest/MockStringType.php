<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use Attribute;
use Override;

use Slendium\Ocd\Schema\Type;

/**
 * A mockable string type that decouples the SchemaAssembler tests from the default implementation.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class MockStringType implements Type, Type\DefaultSerializable {

	public function __construct(

		public string $serializeDefault = '',

	) { }

	#[Override]
	public function isDefaultSerializeValue(mixed $value): bool {
		return $value === $this->serializeDefault;
	}

	#[Override]
	public function getDefaultSerializeValue(): string {
		return $this->serializeDefault;
	}

	#[Override]
	public function serialize(mixed $value): Type\SerializeException|string {
		return \is_string($value)
			? $value
			: new Type\SerializeException('Only accepting strings');
	}

	#[Override]
	public function deserialize(mixed $stored): ?string {
		return \is_string($stored)
			? $stored
			: null;
	}


}
