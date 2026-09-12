<?php

namespace Slendium\Ocd;

/**
 * An operation that updates a field in a document.
 *
 * Library users should never implement this interface, it is only public for type hinting and documentation purposes.
 * The only allowed implementations exist in the `Slendium\Ocd\Update\Stmt` namespace.
 * Implementors can use the {@see Update\Visitor} interface to ensure they cover all current and future types.
 *
 * @since 1.0
 * @see Update\DocumentUpdate For a convenient multi-field document update API
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Update {

	/**
	 * @since 1.0
	 * @template R
	 * @param Update\Visitor<R> $visitor
	 * @return R
	 */
	public function accept(Update\Visitor $visitor): mixed;

}
