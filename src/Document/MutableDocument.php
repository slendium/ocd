<?php

namespace Slendium\Ocd\Document;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use LogicException;
use Override;
use OutOfBoundsException;
use Traversable;

/**
 * @since 1.0
 * @implements ArrayAccess<non-empty-string,mixed>
 * @implements IteratorAggregate<non-empty-string,mixed>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class MutableDocument implements ArrayAccess, Countable, IteratorAggregate {

	/** @since 1.0 */
	public function __construct(

		/** @var array<non-empty-string,mixed> */
		private array $values = [ ],

	) { }

	#[Override]
	public function offsetExists(mixed $offset): bool {
		return isset($this->values[$offset]);
	}

	#[Override]
	public function offsetGet(mixed $offset): mixed {
		return isset($this->values[$offset])
			? $this->values[$offset]
			: throw new OutOfBoundsException("Expected field `$offset` to exist");
	}

	#[Override]
	public function offsetSet(mixed $offset, mixed $value): void {
		if ($offset === null) {
			throw new LogicException('Unexpected document append[], a field name is required');
		}

		$this->values[$offset] = $value;
	}

	#[Override]
	public function offsetUnset(mixed $offset): void {
		unset($this->values[$offset]);
	}

	#[Override]
	public function count(): int {
		return \count($this->values);
	}

	#[Override]
	public function getIterator(): Traversable {
		return new ArrayIterator($this->values); // @phpstan-ignore return.type (bug? ArrayIterator loses its key type)
	}

}
