<?php

namespace Slendium\OcdTests\Unit\Common;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\SequentialValue;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SequentialValueTest extends TestCase {

	public function test_jsonSerialize_shouldProduceIntValue(): void {
		$expectedResult = 15;
		$sut = new SequentialValue($expectedResult);

		$result = $sut->jsonSerialize();

		$this->assertSame($expectedResult, $result);
	}

	public function test___toString_shouldProduceNumericStringValue(): void {
		$expectedResult = 16;
		$sut = new SequentialValue($expectedResult);

		$result = (string)$sut;

		$this->assertSame((string)$expectedResult, $result);
	}

	public function test_hasValue_shouldBeTrue_whenCreatedFromConstructor(): void {
		$sut = new SequentialValue(17);

		$result = $sut->hasValue;

		$this->assertTrue($result);
	}

	public function test_hasValue_shouldBeFalse_whenCreatingGenerationPlaceholder(): void {
		$sut = SequentialValue::generate();

		$result = $sut->hasValue;

		$this->assertFalse($result);
	}

}
