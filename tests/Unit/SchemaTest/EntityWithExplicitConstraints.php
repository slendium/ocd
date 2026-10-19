<?php

namespace Slendium\OcdTests\Unit\SchemaTest;

use DateTimeImmutable;
use Override;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;
use Slendium\Ocd\Query\Predicate;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Schema\Constraint\Invariant(self::INVARIANT_COUNT_GREATER_THAN_ZERO)]
#[Schema\Constraint\Invariant(self::INVARIANT_NAME_ALPHANUMERIC)]
#[Schema\Constraint\ExpireAfter('expireAt')]
#[Schema\Constraint\Unique([ 'category', 'index' ])]
#[Schema\Constraint\Unique([ 'uniqueA', 'uniqueB' ])]
#[Schema\Constraint\Reference(EntityWithScalarFields::class, [ 'category' => 'id' ])]
#[Schema\Constraint\Reference(EntityWithScalarFields::class, [ 'uniqueA' => 'id' ])]
final readonly class EntityWithExplicitConstraints implements Entity {

	const EXPECTED_INVARIANTS = 2;

	const EXPECTED_UNIQUES = 3;

	const EXPECTED_REFERENCES = 2;

	const EXPECTED_CONSTRAINTS = self::EXPECTED_INVARIANTS + self::EXPECTED_UNIQUES + self::EXPECTED_REFERENCES + 1;

	private const INVARIANT_COUNT_GREATER_THAN_ZERO = static function(): Predicate {
		return new Predicate\GreaterThan(new FieldPath([ 'count' ]), 0);
	};

	private const INVARIANT_NAME_ALPHANUMERIC = static function(): Predicate {
		return new Predicate\MatchRegex(new FieldPath([ 'name' ]), '^[a-zA-Z_0-9]+');
	};

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

		public int $count,

		#[Schema\Field\Unique]
		public string $name,

		public DateTimeImmutable $expireAt,

		public string $category,

		public int $index,

		public string $uniqueA,

		public string $uniqueB,

	) { }

}
