<?php

namespace Slendium\OcdTests\Unit\CursorTest;

use Override;

use Slendium\Ocd\Cursor\Scrollable;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class FakeScrollable implements Scrollable {

	#[Override]
	public int $skip = 0;

	#[Override]
	public int $limit = 0;

}
