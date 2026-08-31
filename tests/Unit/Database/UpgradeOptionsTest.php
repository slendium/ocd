<?php

namespace Slendium\OcdTests\Unit\Database;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Database\UpgradeOptions;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class UpgradeOptionsTest extends TestCase {

	public function test___construct_shouldDisallowAllByDefault(): void {
		$result = new UpgradeOptions;

		$this->assertFalse($result->allowTruncate);
		$this->assertFalse($result->allowDrop);
	}

}
