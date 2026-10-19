<?php

namespace Slendium\Ocd\Schema;

use ReflectionParameter;

/**
 * A field within a schema.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class Field {

	/** @internal */
	public static function fromParameterWithType(ReflectionParameter $parameter, Type $type): self {
		return new self(
			name: $parameter->name, // @phpstan-ignore argument.type (can't be empty)
			type: $type,
			isNullable: $parameter->allowsNull(),
			defaultValue: $parameter->isOptional()
				? $parameter->getDefaultValue()
				: null,
		);
	}

	private function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-string
		 */
		public string $name,

		/** @since 1.0 */
		public Type $type,

		/** @since 1.0 */
		public bool $isNullable,

		/** @since 1.0 */
		public mixed $defaultValue,

	) { }

}
