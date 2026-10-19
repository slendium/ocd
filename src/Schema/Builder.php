<?php

namespace Slendium\Ocd\Schema;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionParameter;

use Slendium\Ocd\Entity;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Builder {

	/** @param ReflectionClass<object> $reflector */
	public static function forClass(ReflectionClass $reflector): self {
		return new self(
			$reflector->name,
			\array_flip(PrimaryFields::getNamesForClass($reflector)),
			indexes: self::getIndexesForClass($reflector),
			constraints: self::getConstraintsForClass($reflector),
		);
	}

	private function __construct(

		/** @var class-string */
		private readonly string $name,

		/** @var array<non-empty-string,int> */
		private readonly array $primaryNames,

		/** @var array<non-empty-string,Field> */
		private array $fields = [ ],

		/** @var list<Field> */
		private array $primaries = [ ],

		/** @var list<Index> */
		private array $indexes = [ ],

		/** @var list<Constraint> */
		private array $constraints = [ ],

	) { }

	public function addFieldParameter(ReflectionParameter $parameter): void {
		$meta = FieldMetadata::create($parameter);
		$this->fields[$meta->field->name] = $meta->field;

		if (isset($this->primaryNames[$meta->field->name])) {
			$this->primaries[] = $meta->field;
		}

		if (Field\Indexed::isMarked($parameter)) {
			$this->indexes[] = new Index([ $meta->field->name ]);
		}

		if (Field\Unique::isMarked($parameter)) {
			$this->constraints[] = new Constraint\Unique([ $meta->field->name ]);
		}

		if ($meta->reference !== null) {
			$this->constraints[] = $meta->reference;
		}
	}

	/**
	 * @return array{
	 *  fields: array<non-empty-string,Field>,
	 *  primaries: list<Field>,
	 *  indexes: list<Index>,
	 *  constraints: list<Constraint>
	 * }
	 */
	public function build(): array {
		if (\count($this->primaries) !== \count($this->primaryNames)) {
			throw DefinitionException::forPrimaryFieldsMismatch(
				class: $this->name,
				given: \array_map(static fn($field) => $field->name, $this->primaries),
				expected: \array_keys($this->primaryNames),
			);
		}

		return [
			'fields' => $this->fields,
			'primaries' => $this->primaries,
			'indexes' => $this->indexes,
			'constraints' => $this->constraints,
		];
	}

	/**
	 * @param ReflectionClass<object> $reflector
	 * @return list<Index>
	 */
	private static function getIndexesForClass(ReflectionClass $reflector): array {
		return $reflector->getAttributes(Index::class)
			|> (static fn($x) => \array_map(static fn($attr) => $attr->newInstance(), $x));
	}

	/**
	 * @param ReflectionClass<object> $reflector
	 * @return list<Constraint>
	 */
	private static function getConstraintsForClass(ReflectionClass $reflector): array {
		return $reflector->getAttributes(Constraint::class, ReflectionAttribute::IS_INSTANCEOF)
			|> (static fn($x) => \array_map(static fn($attr) => $attr->newInstance(), $x));
	}

}
