<?php

namespace Slendium\OcdTests\Common\Entities\BadFieldReference;

use Slendium\Ocd\Schema\PrimaryFields;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[PrimaryFields([ 'field' ])]
final readonly class Recursive {

	public function __construct(public self $field) { }

}
