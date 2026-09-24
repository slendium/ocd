<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Types\Enumeration;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class EnumerationTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = EnumerationTest\FakeBackedEnum::class;

		$result = new Enumeration(backedEnumClass: $expectedResult)->backedEnumClass;

		$this->assertSame($expectedResult, $result);
	}

}
