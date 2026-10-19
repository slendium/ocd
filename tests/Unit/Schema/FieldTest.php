<?php

namespace Slendium\OcdTests\Unit\Schema;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;
use Slendium\OcdTests\Common\Entities as TestEntities;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class FieldTest extends TestCase {

	public function test_shouldNotThrowForAnyBuiltinType(): void {
		// Assert
		$this->expectNotToPerformAssertions();

		// Act
		foreach (Schema::fromClass(FieldTest\BuiltinTypesEntity::class)->fields as $field) {
			$_ = $field->type;
		}
	}

	public function test_shouldNotThrowForAnyOverrideType(): void {
		// Assert
		$this->expectNotToPerformAssertions();

		// Act
		foreach (Schema::fromClass(FieldTest\BuiltinTypesAsAttributesEntity::class)->fields as $field) {
			$_ = $field->type;
		}
	}

	public function test_isNullable_shouldBeFalse_whenTypeIsNotNullableAndHasNonNullDefault(): void {
		$sut = Schema::fromClass(FieldTest\NonNullableFieldWithDefaultEntity::class)->fields['defaultString'];

		$resultNullable = $sut->isNullable;
		$resultDefaultValue = $sut->defaultValue;

		$this->assertFalse($resultNullable);
		$this->assertSame('', $resultDefaultValue);
	}

	public function test_isNullable_shouldBeTrue_whenTypeIsNullableButParameterIsRequired(): void {
		$sut = Schema::fromClass(FieldTest\NullableFieldEntity::class)->fields['nullableString'];

		$resultNullable = $sut->isNullable;
		$resultDefaultValue = $sut->defaultValue;

		$this->assertTrue($resultNullable);
		$this->assertNull($resultDefaultValue); // should not throw
	}

	public function test_defaultValue_shouldTakeDeclaredValue_whenTypeIsNullable(): void {
		$sut = Schema::fromClass(FieldTest\NullableFieldWithDefaultEntity::class)->fields['defaultInt'];

		$resultNullable = $sut->isNullable;
		$resultDefaultValue = $sut->defaultValue;

		$this->assertTrue($resultNullable);
		$this->assertSame(FieldTest\NullableFieldWithDefaultEntity::DEFAULT_VALUE, $resultDefaultValue);
	}

}
