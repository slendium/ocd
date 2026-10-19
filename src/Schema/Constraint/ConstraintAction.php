<?php

namespace Slendium\Ocd\Schema\Constraint;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
enum ConstraintAction {

	/** @since 1.0 */
	case Restrict;

	/** @since 1.0 */
	case Cascade;

	/** @since 1.0 */
	case SetNull;

}
