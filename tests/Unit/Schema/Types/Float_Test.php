<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Types\Float_;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Float_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = 3;

		$result = new Float_(bytes: $expectedResult)->bytes;

		$this->assertSame($expectedResult, $result);
	}

}
