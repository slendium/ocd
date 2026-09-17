<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NullableFieldEntity implements Entity {

	public function __construct(

		#[Override]
		public readonly Entity\Id $id,

		public ?string $nullableString,

	) { }


}
