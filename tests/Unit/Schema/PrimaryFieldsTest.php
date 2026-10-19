<?php

namespace Slendium\OcdTests\Unit\Schema;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\PrimaryFields;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class PrimaryFieldsTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = [ 'id' ];

		$sut = new PrimaryFields(names: $expectedResult);

		$this->assertSame($expectedResult, $sut->names);
	}

}
