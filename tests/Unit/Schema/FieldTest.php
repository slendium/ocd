<?php

namespace Slendium\OcdTests\Unit\Schema;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class FieldTest extends TestCase {

	public static function definitionExceptionCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ FieldTest\CallableFieldEntity::class, 'callable' ];
		yield [ FieldTest\MixedFieldEntity::class, 'mixed' ];
		yield [ FieldTest\UntypedFieldEntity::class, 'untyped' ];
		yield [ FieldTest\UnionTypedFieldEntity::class, 'union' ];
		yield [ FieldTest\IntersectionTypedFieldEntity::class, 'intersection' ];
	}

	/**
	 * @param class-string<Entity> $entityClass
	 * @param non-empty-string $fieldName
	 */
	#[DataProvider('definitionExceptionCases')]
	public function test_shouldThrow_whenProvidedWithUnsupportedEntityDefinition(string $entityClass, string $fieldName): void {
		// Arrange
		$sut = Schema::fromConstructorParameters($entityClass);

		// Assert
		$this->expectException(Schema\DefinitionException::class);

		// Act
		$_ = $sut->fields[$fieldName];
	}

	public function test_nullable_shouldBeFalse_whenTypeIsNotNullableAndHasNonNullDefault(): void {
		$sut = Schema::fromConstructorParameters(FieldTest\NonNullableFieldWithDefaultEntity::class)->fields['defaultString'];

		$resultNullable = $sut->nullable; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)
		$resultDefaultValue = $sut->defaultValue; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertFalse($resultNullable);
		$this->assertSame('', $resultDefaultValue);
	}

	public function test_nullable_shouldBeTrue_whenTypeIsNullableButParameterIsRequired(): void {
		$sut = Schema::fromConstructorParameters(FieldTest\NullableFieldEntity::class)->fields['nullableString'];

		$resultNullable = $sut->nullable; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)
		$resultDefaultValue = $sut->defaultValue; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertTrue($resultNullable);
		$this->assertNull($resultDefaultValue); // should not throw
	}

	public function test_defaultValue_shouldTakeDeclaredValue_whenTypeIsNullable(): void {
		$sut = Schema::fromConstructorParameters(FieldTest\NullableFieldWithDefaultEntity::class)->fields['defaultInt'];

		$resultNullable = $sut->nullable; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)
		$resultDefaultValue = $sut->defaultValue; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertTrue($resultNullable);
		$this->assertSame(FieldTest\NullableFieldWithDefaultEntity::DEFAULT_VALUE, $resultDefaultValue);
	}

	public function test_originalName_shouldContainExpectedValue_whenFieldIsRenamed(): void {
		$name = FieldTest\RenamedFieldEntity::RENAMED_NAME;
		$expectedResult = FieldTest\RenamedFieldEntity::ORIGINAL_NAME;
		$sut = Schema::fromConstructorParameters(FieldTest\RenamedFieldEntity::class)->fields[$name];

		$result = $sut->originalName; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertSame($expectedResult, $result);
	}

	public function test_originalName_shouldMatchCurrentName_whenFieldIsNotRenamed(): void {
		$name = FieldTest\NonRenamedFieldEntity::FIELD_NAME;
		$sut = Schema::fromConstructorParameters(FieldTest\NonRenamedFieldEntity::class)->fields[$name];

		$resultName = $sut->name; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)
		$resultOriginalName = $sut->originalName; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertSame($name, $resultName);
		$this->assertSame($name, $resultOriginalName);
	}

}
