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
final readonly class IntersectionUnionTypedFieldEntity implements Entity {

	public function __construct(

		#[Override]
		public readonly Entity\Id $id,

		/** @var (ArrayAccess<string,mixed>&Countable)|int */
		public (ArrayAccess&Countable)|int $intersectionUnion,

	) { }


}
