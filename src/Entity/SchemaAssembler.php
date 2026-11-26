<?php

namespace Slendium\Ocd\Entity;

use ArrayAccess;
use Countable;
use Override;
use ReflectionClass;
use Traversable;

use Slendium\Ocd\Common\PartialObject;
use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;

/**
 * Assembles entities from their schema.
 *
 * Currently assumes all documents passed to it are complete and any missing fields will simply be
 * treated as a `null` value.
 * See issue #116 for the progress on partial documents.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SchemaAssembler implements Assembler {

	#[Override]
	public function assemble(ArrayAccess&Countable&Traversable $doc, string $type): object {
		if (\is_a($type, FromDocument::class, allow_string: true)) {
			return [ $type, 'fromDocument' ]($doc);
		}

		$reflector = new ReflectionClass($type);
		$method = Schema\Fields::getFieldsMethod($reflector);
		if ($method === null) {
			return new $type;
		}

		// currently assuming complete/non-projected documents, see issue #116
		$arguments = [ ];
		$fieldParameters = Schema\Fields::getFieldParametersFromMethod($method);
		foreach ($fieldParameters as $parameter) {
			$docValue = isset($doc[$parameter->name])
				? $doc[$parameter->name]
				: null;
			$fieldMetadata = Schema\FieldMetadata::create($parameter);
			$arguments[$parameter->name] = $this->assembleFieldValue($docValue, $fieldMetadata);
		}

		// TODO: some sort of DI mechanism to fill any remaining (non-field) parameters (see issue #113)
		// the return value of the $fieldParameters Generator is a list of the remaining parameters

		// deliberately let it fail if arguments are missing
		return $method->isConstructor() // @phpstan-ignore return.type (unable to statically detect type)
			? $reflector->newInstanceArgs($arguments)
			: $method->invokeArgs(null, $arguments);
	}

	private function assembleFieldValue(mixed $docValue, Schema\FieldMetadata $meta): mixed {
		if ($meta->reference !== null) {
			return $this->assembleReference($docValue, $meta->reference);
		}

		if ($docValue === null) {
			if ($meta->field->defaultValue !== null) {
				return $meta->field->defaultValue;
			}
			if ($meta->field->isNullable) {
				return null;
			}
		}

		$fieldValue = $meta->field->type->deserialize($docValue);
		return $fieldValue === null
				&& !$meta->field->isNullable
				&& $meta->field->type instanceof Schema\Type\DefaultSerializable
			? $meta->field->type->deserialize($meta->field->type->getDefaultSerializeValue())
			: $fieldValue;
	}

	private function assembleReference(mixed $docValue, Schema\Constraint\Reference $reference): object {
		if (self::isSubDocument($docValue)) {
			return $this->assemble($docValue, $reference->targetClass);
		}

		$arguments = [ ];
		// fields can only reference a single primary key, so this should iterate only once
		foreach ($reference->fieldMapping as $field) {
			$arguments[$field->name] = $field->type->deserialize($docValue);
		}

		return PartialObject::create(new ReflectionClass($reference->targetClass), $arguments);
	}

	/** @phpstan-assert-if-true ArrayAccess<non-empty-string,mixed>&Countable&Traversable<non-empty-string,mixed> $value */
	private static function isSubDocument(mixed $value): bool {
		return $value instanceof ArrayAccess
			&& $value instanceof Countable
			&& $value instanceof Traversable;
	}

}
