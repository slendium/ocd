<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Types\String_;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class String_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = 10;

		$result = new String_(characterLimit: $expectedResult)->characterLimit;

		$this->assertSame($expectedResult, $result);
	}

}
