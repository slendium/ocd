<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class NonRenamedFieldEntity implements Entity {

	const FIELD_NAME = 'field';

	public function __construct(public string $field) { }

}
