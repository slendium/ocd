<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithNullableDefaultableField implements Entity {

	const string FIELD_DEFAULT = '3baa737c-4bcf-47d4-b568-e6e89fd6a081';

	public function __construct(

		#[Override]
		public string $id,

		#[MockStringType]
		public ?string $field = self::FIELD_DEFAULT,

	) { }

}
