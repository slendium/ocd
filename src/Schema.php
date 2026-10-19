<?php

namespace Slendium\Ocd;

use ReflectionClass;

/**
 * Definition of a class' database representation, constraints and relationships.
 *
 * ## Field derivation
 *
 * By default the schema fields are derived from the constructor parameters.
 * The {@see Entity\FromFields} interface can be implemented to derive fields from a static constructor
 * method called `::fromFields()` instead.
 *
 * If a class implements {@see Entity} it must declare an `id` field, which will become the only primary field.
 * The {@see Schema\Exclude} attribute can be used to prevent a parameter from being converted to a field.
 *
 * ## Primary, unique and indexed fields
 *
 * Indexes can be declared by adding {@see Schema\Index} attributes to a class.
 * They may also be declared per field using the {@see Schema\Field\Indexed} attribute.
 * Unique fields are marked using the {@see Schema\Field\Unique} attribute.
 *
 * An {@see Entity} can only have a single primary field called `id`.
 * Other objects may declare their primary fields by adding a {@see Schema\PrimaryFields} attribute
 * to the class.
 *
 * Both primary and unique fields will be indexed, but they won't show up in the schema's
 * {@see Schema::$indexes} list.
 *
 * ## Advanced constraints
 *
 * Advanced constraints that potentially involve multiple fields or schema's can be declared at the
 * top of a class.
 *
 * * Composite unique fields an be created with the {@see Schema\Constraint\Unique} attribute
 * * Documents can be made to automatically expire using the {@see Schema\Constraint\ExpireAfter}
 *   attribute for databases that support it (such as [MongoDB](https://www.mongodb.com/docs/manual/tutorial/expire-data/))
 * * Invariants can be declared with {@see Schema\Constraint\Invariant} attributes for databases that
 *   support it (such as [MariaDB](https://mariadb.com/docs/server/reference/sql-statements/data-definition/constraint#check-constraints))
 *
 * ### References
 *
 * Classes with a schema can be referenced just like any other type.
 * This will create a field that matches the primary field of the referenced class and will automatically
 * add a {@see Schema\Constraint\Reference} constraint (aka. foreign key) to the schema.
 * Note that this requires the referenced class to have exactly one primary key.
 *
 * More complex relationships can be defined with {@see Schema\Constraint\Reference} attributes.
 * The default reference options of a single field can be overridden with the {@see Schema\Field\Reference}
 * attribute.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Schema {

	/**
	 * Creates the schema for the given class.
	 * @since 1.0
	 * @param class-string $class
	 * @return self A lazy ghost object that will delay schema evaluation until it is used
	 */
	public static function fromClass(string $class): self {
		return new ReflectionClass(self::class)->newLazyGhost(static function(self $object) use ($class) {
			$reflector = new ReflectionClass($class);
			$builder = Schema\Builder::forClass($reflector);

			foreach (Schema\Fields::getFieldParameters($reflector) as $parameter) {
				$builder->addFieldParameter($parameter);
			}

			$object->__construct(...$builder->build());
		});
	}

	private function __construct(

		/**
		 * @since 1.0
		 * @var array<non-empty-string,Schema\Field>
		 */
		public array $fields,

		/**
		 * @since 1.0
		 * @var list<Schema\Field>
		 */
		public array $primaries,

		/**
		 * @since 1.0
		 * @var list<Schema\Index>
		 */
		public array $indexes,

		/**
		 * @since 1.0
		 * @var list<Schema\Constraint>
		 */
		public array $constraints,

	) { }

}
