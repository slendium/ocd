<?php

namespace Slendium\Ocd\Collection;

use Slendium\Ocd\Common\Command;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface WriteCommand extends Command {

	/** @since 1.0 */
	public WriteOptions $writeOptions { get; }

}
