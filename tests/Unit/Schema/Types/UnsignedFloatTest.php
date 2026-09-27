<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Types\UnsignedFloat;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UnsignedFloatTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = 5;

		$result = new UnsignedFloat(bytes: $expectedResult)->bytes;

		$this->assertSame($expectedResult, $result);
	}

}
