<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use ArrayAccess;
use Countable;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class IntersectionTypedFieldEntity implements Entity {

	public function __construct(

		/** @var ArrayAccess<string,mixed>&Countable */
		public ArrayAccess&Countable $intersection,

	) { }


}
