<?php

namespace Slendium\Ocd\Schema\Constraint;

use Attribute;
use ReflectionClass;
use ReflectionParameter;

use Slendium\Ocd\Schema;

/**
 * Enforces that the value of a (combination of) field(s) matches the primary field(s) of another object.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Reference implements Schema\Constraint {

	/**
	 * Contains a mapping of source field names to the resolved target fields.
	 * @since 1.0
	 * @var non-empty-array<non-empty-string,Schema\Field>
	 */
	public array $fieldMapping;

	/**
	 * @internal
	 * @param non-empty-string $sourceField
	 * @param class-string $targetClass
	 */
	public static function createForFieldReference(string $sourceField, string $targetClass, ?Schema\Field\Reference $options = null): self {
		$primaries = Schema\PrimaryFields::getNamesForClass(new ReflectionClass($targetClass));
		if (\count($primaries) !== 1) {
			throw \count($primaries) > 1
				? Schema\DefinitionException::forCompositeFieldReference($sourceField, $targetClass)
				: Schema\DefinitionException::forEmptyFieldReference($sourceField, $targetClass);
		}

		$options ??= new Schema\Field\Reference;
		return new self($targetClass, [ $sourceField => $primaries[0] ], $options->onUpdate, $options->onDelete);
	}

	/**
	 * @since 1.0
	 * @param non-empty-array<non-empty-string,non-empty-string> $fieldMapping
	 */
	public function __construct(

		/**
		 * The class of the target object whose primary fields are referenced.
		 * @since 1.0
		 * @var class-string
		 */
		public string $targetClass,

		array $fieldMapping,

		/** @since 1.0 */
		public ConstraintAction $onUpdate = ConstraintAction::Cascade,

		/** @since 1.0 */
		public ConstraintAction $onDelete = ConstraintAction::Restrict,

	) {
		$this->fieldMapping = self::resolveFieldMapping($targetClass, $fieldMapping);
	}

	/**
	 * @param class-string $targetClass
	 * @param non-empty-array<non-empty-string,non-empty-string> $mapping
	 * @return non-empty-array<non-empty-string,Schema\Field>
	 */
	private static function resolveFieldMapping(string $targetClass, array $mapping): array {
		$targetFields = \array_flip(\array_values($mapping));

		foreach (Schema\Fields::getFieldParameters(new ReflectionClass($targetClass)) as $parameter) {
			if (isset($targetFields[$parameter->name])) {
				$targetFields[$parameter->name] = self::createExplicitlyTypedField($parameter, $targetClass);
			}
		}

		foreach ($mapping as $source => $target) {
			if (\is_int($targetFields[$target])) {
				throw Schema\DefinitionException::forReferenceToNonExistentField($target, $targetClass);
			}
			$mapping[$source] = $targetFields[$target];
		}

		return $mapping;
	}

	private static function createExplicitlyTypedField(ReflectionParameter $parameter, string $targetClass): Schema\Field {
		$type = Schema\Types::fromFieldParameter($parameter);
		return \is_string($type)
			? throw Schema\DefinitionException::forReferenceFieldReference($parameter->name, $targetClass)
			: Schema\Field::fromParameterWithType($parameter, $type);
	}

}
