<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use Override;

use Slendium\Ocd\Common\UniqueIdentifier;
use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema\Types as SchemaTypes;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class BuiltinTypesAsAttributesEntity implements Entity {

	public function __construct(

		#[Override]
		public UniqueIdentifier $id,

		#[SchemaTypes\DateTime]
		public mixed $dateTime,

		#[SchemaTypes\DateTimeMutable]
		public mixed $dateTimeMutable,

		#[SchemaTypes\Blob]
		public mixed $blob,

		#[SchemaTypes\Enumeration(FakeBackedEnum::class)]
		public mixed $enum,

		#[SchemaTypes\Map]
		public mixed $map,

		#[SchemaTypes\String_]
		public mixed $string,

		#[SchemaTypes\Float_]
		public mixed $float,

		#[SchemaTypes\Int_]
		public mixed $int,

		#[SchemaTypes\Bool_]
		public mixed $bool,

	) { }

}
