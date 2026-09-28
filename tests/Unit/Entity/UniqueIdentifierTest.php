<?php

namespace Slendium\OcdTests\Unit\Common;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Entity\UniqueIdentifier;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UniqueIdentifierTest extends TestCase {

	public function test_jsonSerialize_shouldProduceBackingValue(): void {
		$expectedResult = '524a15bb-e72b-4c23-a8e5-e624eb310d2f';
		$backingValue = new class($expectedResult) {
			public function __construct(private string $stringValue) { }
			public function __toString(): string { return $this->stringValue; }
		};
		$sut = new UniqueIdentifier($backingValue);

		$result = $sut->jsonSerialize();

		$this->assertSame($expectedResult, $result);
	}

	public function test___toString_shouldProduceBackingValue(): void {
		$expectedResult = 'b52a5627-9a35-4dde-8657-85221ccf5d4e';
		$backingValue = new class($expectedResult) {
			public function __construct(private string $stringValue) { }
			public function __toString(): string { return $this->stringValue; }
		};
		$sut = new UniqueIdentifier($backingValue);

		$result = (string)$sut;

		$this->assertSame($expectedResult, $result);
	}

	public function test_hasValue_shouldBeTrue_whenCreatedFromConstructor(): void {
		$sut = new UniqueIdentifier('714f1ba1-87e2-41fb-90d6-ef94881f2d13');

		$result = $sut->hasValue;

		$this->assertTrue($result);
	}

	public function test_hasValue_shouldBeFalse_whenCreatingGenerationPlaceholder(): void {
		$sut = UniqueIdentifier::generate();

		$result = $sut->hasValue;

		$this->assertFalse($result);
	}

}
