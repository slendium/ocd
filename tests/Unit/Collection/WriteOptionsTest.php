<?php

namespace Slendium\OcdTests\Unit\Collection;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Collection\WriteOptions;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class WriteOptionsTest extends TestCase {

	public function test___construct_shouldNotSetAnyDefaultAcknowledgment(): void {
		$result = new WriteOptions;

		$this->assertNull($result->acknowledgment);
	}

}
