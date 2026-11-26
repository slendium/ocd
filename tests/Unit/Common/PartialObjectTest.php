<?php

namespace Slendium\OcdTests\Unit\Common;

use ReflectionClass;
use RuntimeException;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\PartialObject;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class PartialObjectTest extends TestCase {

	public function test_create_shouldProducePartial(): void {
		// Arrange
		$reflector = new ReflectionClass(PartialObjectTest\FakeObject::class);
		$properties = [ 'a' => 1 ];

		// Act
		$sut = PartialObject::create($reflector, $properties);

		// Assert
		$this->assertTrue(PartialObject::isPartial($sut));
		$this->expectException(RuntimeException::class);

		// Act (should throw)
		$_ = $sut->b;
	}

	public function test_create_shouldProduceNonPartial_whenAllPropertiesProvided(): void {
		$reflector = new ReflectionClass(PartialObjectTest\FakeObject::class);
		$properties = [ 'a' => 1, 'b' => '2', 'c' => true ];

		$sut = PartialObject::create($reflector, $properties);

		$this->assertFalse(PartialObject::isPartial($sut));
	}

}
