<?php

namespace Slendium\Ocd\Entity;

use JsonSerializable;
use Override;
use ReflectionClass;
use ReflectionProperty;
use Stringable;

/**
 * A wrapper for database's custom UUID/GUID type.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UniqueIdentifier implements JsonSerializable {

	/**
	 * Checks if this unique identifier has a value and isn't a placeholder for a yet to-be-generated value.
	 * @since 1.0
	 */
	public bool $hasValue {
		get => new ReflectionProperty($this, 'backingValue')->isInitialized($this);
	}

	/** @since 1.0 */
	public static function generate(): self {
		return new ReflectionClass(self::class)->newLazyGhost(static function(self $object) { });
	}

	/** @since 1.0 */
	public function __construct(

		/** @since 1.0 */
		public readonly Stringable|string $backingValue,

	) { }

	#[Override]
	public function jsonSerialize(): string {
		return (string)$this->backingValue;
	}

	public function __toString(): string {
		return (string)$this->backingValue;
	}

}
