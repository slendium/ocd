<?php

namespace Slendium\OcdTests\Unit\Schema\FieldTest;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Override;

use Slendium\Ocd\Common\Blob;
use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class BuiltinTypesEntity implements Entity {

	public function __construct(

		#[Override]
		public Entity\Id $id,

		public DateTime $dateTime,

		public DateTimeImmutable $dateTimeImmutable,

		public DateTimeInterface $dateTimeInterface,

		public Blob $blob,

		public FakeBackedEnum $enum,

		/** @var array<mixed> */
		public array $map,

		public string $string,

		public float $float,

		public int $int,

		public bool $bool,

	) { }

}
