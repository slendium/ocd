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

	public static function definitionExceptionCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield 'callable' => [ FieldTest\CallableFieldEntity::class, 'callable' ];
		yield 'mixed' => [ FieldTest\MixedFieldEntity::class, 'mixed' ];
		yield 'untyped' => [ FieldTest\UntypedFieldEntity::class, 'untyped' ];
		yield 'union' => [ FieldTest\UnionTypedFieldEntity::class, 'union' ];
		yield 'intersection' => [ FieldTest\IntersectionTypedFieldEntity::class, 'intersection' ];
		yield 'intersection+union' => [ FieldTest\IntersectionUnionTypedFieldEntity::class, 'intersectionUnion' ];
		yield 'unit-enum' => [ FieldTest\UnitEnumFieldEntity::class, 'enumeration' ];
		yield 'too-many-types' => [ FieldTest\TooManyTypesFieldEntity::class, 'tooMany' ];
		yield 'variadic' => [ FieldTest\VariadicFieldEntity::class, 'variadic' ];
	}

	/**
	 * @param class-string<Entity> $entityClass
	 * @param non-empty-string $fieldName
	 */
	#[DataProvider('definitionExceptionCases')]
	public function test_shouldThrow_whenProvidedWithUnsupportedEntityDefinition(string $entityClass, string $fieldName): void {
		// Arrange
		$sut = Schema::fromClass($entityClass);

		// Assert
		$this->expectException(Schema\DefinitionException::class);

		// Act
		$_ = $sut->fields[$fieldName]->type; // @phpstan-ignore property.nonObject (the field will be found)
	}

	public function test_isNullable_shouldBeFalse_whenTypeIsNotNullableAndHasNonNullDefault(): void {
		$sut = Schema::fromClass(FieldTest\NonNullableFieldWithDefaultEntity::class)->fields['defaultString'];

		$resultNullable = $sut->isNullable; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)
		$resultDefaultValue = $sut->defaultValue; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertFalse($resultNullable);
		$this->assertSame('', $resultDefaultValue);
	}

	public function test_isNullable_shouldBeTrue_whenTypeIsNullableButParameterIsRequired(): void {
		$sut = Schema::fromClass(FieldTest\NullableFieldEntity::class)->fields['nullableString'];

		$resultNullable = $sut->isNullable; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)
		$resultDefaultValue = $sut->defaultValue; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertTrue($resultNullable);
		$this->assertNull($resultDefaultValue); // should not throw
	}

	public function test_defaultValue_shouldTakeDeclaredValue_whenTypeIsNullable(): void {
		$sut = Schema::fromClass(FieldTest\NullableFieldWithDefaultEntity::class)->fields['defaultInt'];

		$resultNullable = $sut->isNullable; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)
		$resultDefaultValue = $sut->defaultValue; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertTrue($resultNullable);
		$this->assertSame(FieldTest\NullableFieldWithDefaultEntity::DEFAULT_VALUE, $resultDefaultValue);
	}

	public function test_originalName_shouldContainExpectedValue_whenFieldIsRenamed(): void {
		$name = FieldTest\RenamedFieldEntity::RENAMED_NAME;
		$expectedResult = FieldTest\RenamedFieldEntity::ORIGINAL_NAME;
		$sut = Schema::fromClass(FieldTest\RenamedFieldEntity::class)->fields[$name];

		$result = $sut->originalName; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertSame($expectedResult, $result);
	}

	public function test_originalName_shouldMatchCurrentName_whenFieldIsNotRenamed(): void {
		$name = FieldTest\NonRenamedFieldEntity::FIELD_NAME;
		$sut = Schema::fromClass(FieldTest\NonRenamedFieldEntity::class)->fields[$name];

		$resultName = $sut->name; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)
		$resultOriginalName = $sut->originalName; // @phpstan-ignore property.nonObject (bug? offset either throws or returns a Field)

		$this->assertSame($name, $resultName);
		$this->assertSame($name, $resultOriginalName);
	}

}
