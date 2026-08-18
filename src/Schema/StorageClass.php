<?php

namespace Slendium\Ocd\Schema;

/**
 * The fundamental storage types of fields.
 *
 * Complex {@see Type}'s must all ultimately be representable as one of these types.
 * Implementors may fold multiple of them into the same native type if it makes sense, such as storing
 * `DateTime`'s as an integer or storing integers and floating point numbers as a common "number" type.
 *
 * @since 1.0
 * @see TypeInfo::getStorageClass()
 * @author C. Fahner
 * @copyright Slendium 2026
 */
enum StorageClass : string {

	/** @since 1.0 */
	case String = 'string';

	/** @since 1.0 */
	case Float = 'float';

	/** @since 1.0 */
	case Int = 'int';

	/** @since 1.0 */
	case Bool = 'bool';

}
