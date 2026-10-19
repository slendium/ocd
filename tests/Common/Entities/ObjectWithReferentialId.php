<?php

namespace Slendium\OcdTests\Common\Entities;

use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Schema\PrimaryFields([ 'id' ])]
final readonly class ObjectWithReferentialId {

	public function __construct(public EntityWithId $id) { }

}
