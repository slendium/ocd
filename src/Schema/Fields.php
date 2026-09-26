<?php

namespace Slendium\Ocd\Schema;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use LogicException;
use OutOfBoundsException;
use Override;
use ReflectionParameter;
use Traversable;

use Slendium\Ocd\Schema;

/**
 * @internal
 * @implements ArrayAccess<non-empty-string,Field>
 * @implements IteratorAggregate<non-empty-string,Field>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Fields implements ArrayAccess, Countable, IteratorAggregate {

	/** @var array<non-empty-string,Field> */
	private array $map;

	/** @param list<ReflectionParameter> $parameters */
	public static function fromParameters(array $parameters): self {
		$fields = [ ];
		foreach ($parameters as $parameter) {
			if (self::isParameterEligible($parameter)) {
				$field = Field::fromParameter($parameter);
				$fields[$field->name] = $field;
			}
		}
		return new self($fields);
	}

	private static function isParameterEligible(ReflectionParameter $parameter): bool {
		foreach ($parameter->getAttributes(Schema\Exclude::class) as $attr) {
			return false;
		}
		return true;
	}

	/** @param array<non-empty-string,Field> $fields */
	public function __construct(array $fields) {
		$this->map = $fields;
	}

	#[Override]
	public function offsetExists(mixed $offset): bool {
		return isset($this->map[$offset]);
	}

	#[Override]
	public function offsetGet(mixed $offset): Field {
		return isset($this->map[$offset])
			? $this->map[$offset]
			: throw new OutOfBoundsException("Unexpected field offset `$offset`, field doesn't exist");
	}

	#[Override]
	public function offsetSet(mixed $offset, mixed $value): void {
		throw new LogicException('Attempt to modify set of fields');
	}

	#[Override]
	public function offsetUnset(mixed $offset): void {
		throw new LogicException('Attempt to modify set of fields');
	}

	#[Override]
	public function count(): int {
		return \count($this->map);
	}

	#[Override]
	public function getIterator(): Traversable {
		return new ArrayIterator($this->map); // @phpstan-ignore return.type (bug? turns into TKey of ArrayIterator turns into string even though the input TKey is non-empty-string)
	}

}
