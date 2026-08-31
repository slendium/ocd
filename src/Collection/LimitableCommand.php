<?php

namespace Slendium\Ocd\Collection;

use Slendium\Ocd\Common\Command;

/**
 * A command that can be limited to a given number of documents.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface LimitableCommand extends Command {

	/**
	 * The amount of documents the command should apply to.
	 *
	 * A value of `0` indicates "no limits."
	 *
	 * Note that some databases (MongoDB) only support the values `0` (unlimited) and `1` on update/delete commands.
	 * Do not set this value to anything else for these commands if you intend to support these databases.
	 *
	 * @since 1.0
	 * @var int<0,max>
	 */
	public int $limit { get; set; }

}
