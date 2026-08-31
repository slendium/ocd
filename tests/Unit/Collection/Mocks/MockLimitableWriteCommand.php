<?php

namespace Slendium\OcdTests\Unit\Collection\Mocks;

use Override;

use Slendium\Ocd\Collection\LimitableCommand;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class MockLimitableWriteCommand extends MockWriteCommand implements LimitableCommand {

	#[Override]
	public int $limit = 0;

}
