<?php

namespace Slendium\OcdTests\Unit\CursorTest;

use Override;

use Slendium\Ocd\Cursor\Filterable;
use Slendium\Ocd\Query\Predicate;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class FakeFilterable implements Filterable {

	#[Override]
	public ?Predicate $filter = null;

}
