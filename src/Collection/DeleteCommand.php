<?php

namespace Slendium\Ocd\Collection;

use Slendium\Ocd\Common\Command;

/**
 * Safe / recommended operations for delete commands.
 *
 * ## Example
 *
 * ```php
 * $collection->startDelete($filter)
 * 	|> DeleteCommand::enforceLimit(?, 1)
 * 	|> DeleteCommand::fireAndForget(?);
 * ```
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DeleteCommand {

	use CommonWriteCommandUtils;

	use CommonUpdateAndDeleteCommandUtils;

	private function __construct() { }

}
