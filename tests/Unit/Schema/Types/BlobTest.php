<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Types\Blob;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class BlobTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = 7_384_284;

		$result = new Blob(byteLimit: $expectedResult)->byteLimit;

		$this->assertSame($expectedResult, $result);
	}

}
