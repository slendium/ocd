<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldType;

use Override;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema\Exclude;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class EntityWithExcludedVariadicField implements Entity {

	public function __construct( // @phpstan-ignore constructor.unusedParameter

		#[Override]
		public readonly Entity\UniqueIdentifier $id,

		#[Exclude] // ignored for variadics
		string ...$field,

	) { }

}
