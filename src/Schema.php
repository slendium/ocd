<?php

namespace Slendium\Ocd;

use ArrayAccess;
use Countable;
use Traversable;
use ReflectionClass;
use ReflectionParameter;

/**
 * Definition of an {@see Entity}'s structure and its relationships to other entities.
 *
 * * Use the {@see Schema\Exclude} attribute to exclude a field.
 * * Use the {@see Schema\FieldName} attribute to give a field a different database name from it's PHP-declared name.
 * * Use the {@see Schema\IdOptions} attribute to customize the ID of {@see Entity\Identifiable} entities.
 *
 * Currently a schema can only be derived from the constructor parameters of an entity.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Schema {

	/**
	 * Creates a schema for the given class.
	 *
	 * By default the schema is created from the constructor parameters.
	 * Classes can implement {@see Entity\FromFields} to override the default behavior and extract
	 * the schema from the parameters of the static `::fromFields()` method instead.
	 *
	 * If the given class implements {@see Entity} it must declare an `$id` parameter.
	 *
	 * @since 1.0
	 * @param class-string $class
	 */
	public static function fromClass(string $class): self {
		return new ReflectionClass(self::class)->newLazyGhost(static function(self $object) use ($class) {
			$parameters = \is_a($class, Entity\FromFields::class, allow_string: true)
				? new ReflectionClass($class)->getMethod('fromFields')->getParameters()
				: new ReflectionClass($class)->getConstructor()?->getParameters() ?? [ ];
			$fields = Schema\Fields::fromParameters($parameters);

			if (\is_a($class, Entity::class, allow_string: true) && !isset($fields['id'])) {
				throw Schema\DefinitionException::forMissingIdField();
			}

			$object->__construct($fields);
		});
	}

	private function __construct(

		/**
		 * @since 1.0
		 * @var ArrayAccess<non-empty-string,Schema\Field>&Countable&Traversable<Schema\Field>
		 */
		public ArrayAccess&Countable&Traversable $fields,

	) { }

}
