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
	 * The entity's regular fields.
	 *
	 * Does not contain managed fields, such as the `id` of {@see Entity\Identifiable} entities.
	 *
	 * @since 1.0
	 * @var ArrayAccess<non-empty-string,Schema\Field>&Countable&Traversable<Schema\Field>
	 */
	public ArrayAccess&Countable&Traversable $fields;

	/**
	 * Creates a schema from the constructor parameters of a given class.
	 *
	 * If the given class implements {@see Entity\Identifiable} it must declare an `$id` parameter in the constructor.
	 * This parameter must declare a type that implements {@see Entity\Id}.
	 * This `$id` is not a regular field and therefor won't end up in the `$fields` property.
	 *
	 * @since 1.0
	 * @param class-string $class
	 */
	public static function fromConstructorParameters(string $class): self {
		return new ReflectionClass(self::class)->newLazyGhost(static function (self $object) use ($class) {
			$isIdentifiable = \is_a($class, Entity::class, allow_string: true);

			$idOptions = null;
			$fields = [ ];
			foreach (new ReflectionClass($class)->getConstructor()?->getParameters() ?? [ ] as $parameter) {
				if ($isIdentifiable && $parameter->name === 'id') {
					$idOptions = self::extractIdOptions($parameter);
				} else if (self::isParameterEligible($parameter)) {
					$fields[] = Schema\Field::fromParameter($parameter);
				}
			}

			if ($isIdentifiable && $idOptions === null) {
				throw Schema\DefinitionException::forMissingIdField();
			}

			$object->__construct($idOptions, $fields);
		});
	}

	private static function extractIdOptions(ReflectionParameter $idParameter): Schema\IdOptions {
		foreach ($idParameter->getAttributes(Schema\IdOptions::class) as $attr) {
			return $attr->newInstance();
		}
		return new Schema\IdOptions(Schema\IdGenerator::UniqueIdentifier);
	}

	private static function isParameterEligible(ReflectionParameter $parameter): bool {
		foreach ($parameter->getAttributes(Schema\Exclude::class) as $attr) {
			return false;
		}
		return true;
	}

	/** @param iterable<Schema\Field> $fields */
	private function __construct(

		/** @since 1.0 */
		public ?Schema\IdOptions $idOptions,

		iterable $fields,

	) {
		$this->fields = new Schema\Fields($fields);
	}

}
