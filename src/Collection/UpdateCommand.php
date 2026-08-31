<?php

namespace Slendium\Ocd\Collection;

use InvalidArgumentException;

use Slendium\Ocd\Common\Command;
use Slendium\Ocd\Cursor\Limitable;

/**
 * Safe / recommended operations for update commands.
 *
 * ## Example
 *
 * ```php
 * $collection->startUpdate($filter, $updates)
 * 	|> UpdateCommand::suggestLimit(?, 1)
 * 	|> UpdateCommand::setAcknowledgment(?, WriteAcknowledgment::Replicated)
 * 	|> UpdateCommand::execute(?);
 * ```
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UpdateCommand {

	use CommonWriteCommandUtils;

	use CommonUpdateAndDeleteCommandUtils;

	private function __construct() { }

}
