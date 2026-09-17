<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class UntypedFieldEntity implements Entity {

	public mixed $untyped;

	public function __construct( // @phpstan-ignore missingType.parameter (deliberate for test purposes)

		#[Override]
		public readonly Entity\Id $id,

		$untyped,

	) {
		$this->untyped = $untyped;
	}


}
