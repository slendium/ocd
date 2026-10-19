<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use Override;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Schema\Index([ 'fieldB', 'fieldC' ]), Schema\Index([ 'fieldD' ])]
final readonly class EntityWithIndexes implements Entity {

	const EXPECTED_INDEXES = [
		[ 'fieldA' ],
		[ 'fieldB', 'fieldC' ],
		[ 'fieldD' ]
	];

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		#[Schema\Field\Indexed]
		public string $fieldA,

		public string $fieldB,

		public string $fieldC,

		public string $fieldD,

	) { }

}
