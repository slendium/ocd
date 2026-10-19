<?php

namespace Slendium\Ocd\Schema;

/**
 * A database-enforced limitation on the allowed values of fields in a collection.
 *
 * Databases must at minimum support the {@see Constraint\Unique} constraint.
 * Support for the constraints {@see Constraint\Reference}, {@see Constraint\Invariant} and {@see Constraint\ExpireAfter}
 * is not required.
 *
 * Constraints are declared at the top of the class for which to generate a schema.
 * You can also declare a single field as unique using the field-specific {@see Field\Unique} attribute.
 * Declaring a single field as unique will automatically add it as a constraint to the schema.
 *
 * A {@see Constraint\Unique} constraint will not explicitly add the field(s) to the schema's list of
 * indexes, but it should not be considered an error if unique field(s) do end up in the list.
 *
 * ## Example
 *
 * ```php
 * #[Schema\Constraint\Unique([ 'category', 'position' ])]
 * #[Schema\Constraint\Invariant(self::PRICE_GREATER_THAN_ZERO)]
 * #[Schema\Constraint\ExpireAfter('expiresAt')]
 * final readonly class Product implements Entity {
 *
 * 	private const PRICE_GREATER_THAN_ZERO = static function() {
 * 		return new Predicate\GreaterThan(new FieldPath([ 'price' ]), 0);
 * 	};
 *
 * 	public function __construct(
 *
 * 		#[Override]
 * 		public Entity\UniqueIdentifier $id,
 *
 * 		#[Schema\Field\Unique]
 * 		public string $name,
 *
 * 		public string $category,
 *
 * 		public int $position,
 *
 * 		public float $price,
 *
 * 		public DateTimeImmutable $expiresAt,
 *
 * 	) { }
 * }
 * ```
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Constraint { }
