<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NonRenamedFieldEntity implements Entity {

	const FIELD_NAME = 'field';

	public function __construct(

		#[Override]
		public string $id,

		public string $field,

	) { }

}
