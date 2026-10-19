<?php

namespace Slendium\Ocd\Schema;

use Attribute;
use ReflectionClass;

use Slendium\Ocd\Common\MarkerAttribute;
use Slendium\Ocd\Entity;

/**
 * Declares the primary fields for any class that is not an {@see Entity}.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_CLASS)]
final readonly class PrimaryFields {

	use MarkerAttribute;

	/**
	 * @internal
	 * @param ReflectionClass<object> $reflector
	 * @return list<non-empty-string>
	 */
	public static function getNamesForClass(ReflectionClass $reflector): array {
		return \is_a($reflector->name, Entity::class, allow_string: true)
			? [ 'id' ]
			: self::getInstance($reflector)->names ?? [ ];
	}

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var non-empty-list<non-empty-string>
		 */
		public array $names,

	) { }

}
