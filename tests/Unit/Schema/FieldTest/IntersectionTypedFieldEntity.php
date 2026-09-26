<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use ArrayAccess;
use Countable;
use Override;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class IntersectionTypedFieldEntity implements Entity {

	public function __construct(

		#[Override]
		public string $id,

		/** @var ArrayAccess<string,mixed>&Countable */
		public ArrayAccess&Countable $intersection,

	) { }


}
