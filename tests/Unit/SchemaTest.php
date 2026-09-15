<?php

namespace Slendium\OcdTests\Unit;

use Exception;
use OutOfBoundsException;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SchemaTest extends TestCase {

	private const DEFAULT_ID_GENERATOR = Schema\IdGenerator::UniqueIdentifier;

	public function test_createFromConstructorParameters_shouldThrow_whenEntityIsIdentifiableButDoesNotDeclareAnIdParameter(): void {
		// Arrange
		$sut = Schema::fromConstructorParameters(SchemaTest\IdentifiableEntityWithoutIdParameter::class);

		// Assert
		$this->expectException(Schema\DefinitionException::class);

		// Act
		$_ = $sut->fields;
	}

	public function test_fromConstructorParameters_shouldSetDefaultIdGeneratorWithoutIdField_whenEntityIsIdentifiableAndDeclaresIdField(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EmptyIdentifiableEntity::class);

		$resultIdOptions = $sut->idOptions;
		$resultFields = $sut->fields;

		$this->assertSame(self::DEFAULT_ID_GENERATOR, $resultIdOptions->generator);
		$this->assertFalse(isset($resultFields['id']));
	}

	public function test_fromConstructorParameters_shouldIgnoreExcludeAttributeAndSetDefaultGenerator_whenExcludeAttributeIsAppliedToId(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\IdentifiableEntityThatExcludesId::class);

		$result = $sut->idOptions->generator;

		$this->assertSame(self::DEFAULT_ID_GENERATOR, $result);
	}

	public function test_fromConstructorParameters_shouldIncludeScalarFields_whenDeclaredInTheConstructor(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithScalarFields::class);

		$result = $sut->fields;

		$this->assertSame(self::DEFAULT_ID_GENERATOR, $sut->idOptions->generator);
		$this->assertSame(4, \count($result));
		$this->assertTrue(isset($result['string']));
		$this->assertTrue(isset($result['float']));
		$this->assertTrue(isset($result['int']));
		$this->assertTrue(isset($result['bool']));
	}

	public function test_fromConstructorParameters_shouldIncludeBlobField_whenDeclaredInConstructor(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithBlobField::class);

		$result = $sut->fields;

		$this->assertSame(1, \count($result));
		$this->assertTrue(isset($result['blob']));
	}

	public function test_fromConstructorParameters_shouldNotContainExcludedFields(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithExcludedField::class);

		$result = $sut->fields;

		$this->assertSame(1, \count($result));
		$this->assertTrue(isset($result['included']));
		$this->assertFalse(isset($result['excluded']));
	}

	// Allowed, but not recommended
	public function test_fromConstructorParameters_shouldNotThrow_whenObjectDoesNotImplementEntity(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\NonEntity::class);

		$resultIdOptions = $sut->idOptions;
		$resultFields = $sut->fields;

		$this->assertSame(self::DEFAULT_ID_GENERATOR, $resultIdOptions->generator);
		$this->assertSame(2, \count($resultFields));
		$this->assertTrue(isset($resultFields['name']));
		$this->assertTrue(isset($resultFields['counter']));
	}

	public function test_fields_shouldRenameFields_whenDeclaredWithFieldNameAttribute(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithRenamedField::class);

		$result = $sut->fields;

		$this->assertSame(1, \count($result));
		$this->assertTrue(isset($result['alternativeName']));
	}

	public function test_fields_shouldThrow_whenSettingOffset(): void {
		// Arrange
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithScalarFields::class)->fields;

		// Assert
		$this->expectException(Exception::class);

		// Act
		$sut['test'] = 1;
	}

	public function test_fields_shouldThrow_whenUnsettingOffset(): void {
		// Arrange
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithScalarFields::class)->fields;

		// Assert
		$this->expectException(Exception::class);

		// Act
		unset($sut['string']);
	}

	public function test_fields_getIterator_shouldNotThrow(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithScalarFields::class)->fields;

		$count = 0;
		foreach ($sut as $name => $field) {
			$this->assertIsString($name);
			$this->assertInstanceOf(Schema\Field::class, $field);
			$this->assertSame($name, $field->name);
			$count += 1;
		}

		$this->assertSame(4, $count);
	}

	public function test_fields_getIterator_shouldUseRealFieldNameAsKey_whenFieldWasRenamed(): void {
		// Arrange
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithRenamedField::class)->fields;

		// Act
		foreach ($sut as $name => $field) {
			// Assert
			$this->assertSame($name, $field->name);
		}
	}

	public function test_idOptions_shouldBeNull_whenEntityIsNotIdentifiable(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EmptyEntity::class);

		$result = $sut->idOptions;

		$this->assertNull($result);
	}

	public function test_fields_shouldContainIdField_whenEntityDeclaresIdFieldButIsNotIdentifiable(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithRegularIdField::class);

		$result = $sut->fields;

		$this->assertTrue(isset($result['id']));
	}

	public function test_fields_shouldThrow_whenOffsetDoesNotExist(): void {
		// Arrange
		$sut = Schema::fromConstructorParameters(SchemaTest\EmptyEntity::class);

		// Assert
		$this->expectException(OutOfBoundsException::class);

		// Act
		$_ = $sut->fields['does_not_exist'];
	}

	public function test_fields_shouldReturnField_whenOffsetExists(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\EntityWithScalarFields::class);

		$result = $sut->fields['string'];

		$this->assertInstanceOf(Schema\Field::class, $result);
	}

	public function test_idOptions_generator_shouldHaveNonDefaultGenerator_whenEntityDeclaresIdOptions(): void {
		$sut = Schema::fromConstructorParameters(SchemaTest\IdentifiableEntityWithSequentialId::class);

		$result = $sut->idOptions->generator;

		$this->assertSame(Schema\IdGenerator::Sequence, $result);
	}

}
