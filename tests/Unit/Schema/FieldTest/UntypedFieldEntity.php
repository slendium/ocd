<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class UntypedFieldEntity implements Entity {

	public mixed $untyped;

	public function __construct($untyped) { // @phpstan-ignore missingType.parameter (deliberate for test purposes)
		$this->untyped = $untyped;
	}


}
