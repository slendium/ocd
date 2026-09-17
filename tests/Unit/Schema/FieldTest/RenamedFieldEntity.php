<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Override;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class RenamedFieldEntity implements Entity {

	const ORIGINAL_NAME = 'originalName';

	const RENAMED_NAME = 'renamedName';

	public function __construct(

		#[Override]
		public readonly Entity\Id $id,

		#[Schema\FieldName(self::RENAMED_NAME)]
		public string $originalName,

	) { }

}
