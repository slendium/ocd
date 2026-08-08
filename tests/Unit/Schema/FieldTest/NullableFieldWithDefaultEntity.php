<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NullableFieldWithDefaultEntity implements Entity {

	const DEFAULT_VALUE = 67;

	public function __construct(public ?int $defaultInt = self::DEFAULT_VALUE) { }

}
