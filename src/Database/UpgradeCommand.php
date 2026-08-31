<?php

namespace Slendium\Ocd\Database;

use Slendium\Ocd\Common\Command;

/**
 * Contains options to further specify the behavior of upgrades.
 *
 * Currently implementations are instructed to reject any upgrades that contain a field type change.
 * Changing the type should currently be done in steps:
 *
 * 1. Create a new field with a new name that can hold the new type
 * 2. Convert data between the fields if possible and/or necessary
 * 3. Delete the old field
 * 4. If desired, recreate the old field with the new type to reclaim the name
 *
 * An [issue](https://git.frisiapp.com/slendium/ocd/issues/26) exists to track a cleaner implementation
 * of field-specific upgrades.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface UpgradeCommand extends Command {

	/** @since 1.0 */
	public UpgradeOptions $upgradeOptions { get; }

}
