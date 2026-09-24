<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Types\Int_;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Int_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = 3;

		$result = new Int_(bytes: $expectedResult)->bytes;

		$this->assertSame($expectedResult, $result);
	}

}
