<?php

namespace Slendium\Ocd\Collection;

use Slendium\Ocd\Common\Command;

/**
 * Safe / recommended operations for insert commands.
 *
 * ## Example
 *
 * ```php
 * $collection->startInsert([ $doc1, $doc2 ])
 * 	|> InsertCommand::fireAndForget(?);
 * ```
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class InsertCommand {

	use CommonWriteCommandUtils;

	private function __construct() { }

}
