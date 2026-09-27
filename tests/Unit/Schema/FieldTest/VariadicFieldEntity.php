<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class VariadicFieldEntity implements Entity {

	public function __construct( // @phpstan-ignore constructor.unusedParameter

		#[Override]
		public string $id,

		string ...$variadic,

	) { }


}
