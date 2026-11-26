<?php

namespace Slendium\Ocd\Schema\Types;

use Attribute;
use Override;
use Stringable;

use Slendium\Ocd\Schema\Type;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final class String_ implements Type, Type\CharacterLimited, Type\DefaultSerializable {

	/** @since 1.0 */
	const int DEFAULT_CHARACTER_LIMIT = 150;

	/** @since 1.0 */
	const string SERIALIZE_DEFAULT = '';

	private static self $instance;

	/** @internal */
	public static function instance(): self {
		return self::$instance ??= new self;
	}

	/** @since 1.0 */
	public static function deserializeValue(mixed $value): ?string {
		return match(true) {
			\is_string($value) => $value,
			\is_float($value) || \is_int($value) => (string)$value,
			$value instanceof Stringable => $value->__toString(),
			default => null
		};
	}

	/** @since 1.0 */
	public function __construct(

		/** @var int<1,max> */
		#[Override]
		public readonly int $characterLimit = self::DEFAULT_CHARACTER_LIMIT,

	) { }

	#[Override]
	public function serialize(mixed $value): Type\SerializeException|string {
		if ($value === null) {
			return self::SERIALIZE_DEFAULT;
		} else if (\is_string($value)) {
			return $this->ensureLimit($value);
		} else if (\is_float($value) || \is_int($value)) {
			return $this->ensureLimit((string)$value);
		} else if ($value instanceof Stringable) {
			return $this->ensureLimit($value->__toString());
		}
		return new Type\SerializeException('Expected a value that can be stringified, received a '.\get_debug_type($value));
	}

	#[Override]
	public function deserialize(mixed $stored): ?string {
		return self::deserializeValue($stored);
	}

	#[Override]
	public function isDefaultSerializeValue(mixed $value): bool {
		return $value === self::SERIALIZE_DEFAULT;
	}

	#[Override]
	public function getDefaultSerializeValue(): string {
		return self::SERIALIZE_DEFAULT;
	}

	private function ensureLimit(string $value): Type\SerializeException|string {
		return \mb_strlen($value) > $this->characterLimit
			? new Type\SerializeException("Expected string not to exceed character limit ({$this->characterLimit})")
			: $value;
	}

}
