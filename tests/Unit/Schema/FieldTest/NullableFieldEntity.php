<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NullableFieldEntity implements Entity {

	public function __construct(public ?string $nullableString) { }


}
