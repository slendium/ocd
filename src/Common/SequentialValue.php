<?php

namespace Slendium\Ocd\Common;

use JsonSerializable;
use Override;
use ReflectionClass;
use ReflectionProperty;

/**
 * A wrapper for sequentially generated numbers.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SequentialValue implements JsonSerializable {

	/**
	 * Checks if this wrapper has a value and isn't a placeholder for a yet to-be-generated value.
	 * @since 1.0
	 */
	public bool $hasValue {
		get => new ReflectionProperty($this, 'value')->isInitialized($this);
	}

	/** @since 1.0 */
	public static function generate(): self {
		return new ReflectionClass(self::class)->newLazyGhost(static function(self $object) { });
	}

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var int<1,max>
		 */
		public readonly int $value,

	) { }

	public function __toString(): string {
		return (string)$this->value;
	}

	#[Override]
	public function jsonSerialize(): int {
		return $this->value;
	}

}
