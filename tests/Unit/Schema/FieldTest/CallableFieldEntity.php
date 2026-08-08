<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class CallableFieldEntity implements Entity {

	public mixed $result;

	public function __construct(callable $callable) {
		$this->result = $callable();
	}


}
