<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Types\UnsignedInt;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UnsignedIntTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = 5;

		$result = new UnsignedInt(bytes: $expectedResult)->bytes;

		$this->assertSame($expectedResult, $result);
	}

}
