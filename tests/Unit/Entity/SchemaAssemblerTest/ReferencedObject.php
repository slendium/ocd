<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Schema\PrimaryFields([ 'code' ])]
final readonly class ReferencedObject {

	public function __construct(public string $code, public string $name) { }

}
