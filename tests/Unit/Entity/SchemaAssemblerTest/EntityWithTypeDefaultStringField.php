<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EntityWithTypeDefaultStringField implements Entity {

	const string FIELD_TYPE_DEFAULT = '0fe87091-02f0-487f-acc1-497ed79a9597';

	public function __construct(

		#[Override]
		public string $id,

		#[MockStringType(serializeDefault: self::FIELD_TYPE_DEFAULT)]
		public string $field,

	) { }

}
