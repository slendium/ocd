<?php

namespace Slendium\OcdTests\Unit;

use Exception;
use OutOfBoundsException;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\SequentialValue;
use Slendium\Ocd\Common\UniqueIdentifier;
use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SchemaTest extends TestCase {

	public function test_fromClass_shouldThrow_whenEntityExcludesIdField(): void {
		// Arrange
		$sut = Schema::fromClass(SchemaTest\EntityThatExcludesId::class);

		// Assert
		$this->expectException(Schema\DefinitionException::class);

		// Act
		$_ = $sut->fields;
	}

	public function test_fromClass_shouldIgnoreIdField_whenIdFieldOfRegularObjectIsExcluded(): void {
		$sut = Schema::fromClass(SchemaTest\ObjectWithExcludedIdField::class);

		$result = \count($sut->fields);

		$this->assertSame(0, $result);
	}

	public function test_fromClass_shouldIncludeScalarFields_whenDeclaredInTheConstructor(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithScalarFields::class);

		$result = $sut->fields;

		$this->assertSame(5, \count($result));
		$this->assertTrue(isset($result['id']));
		$this->assertTrue(isset($result['string']));
		$this->assertTrue(isset($result['float']));
		$this->assertTrue(isset($result['int']));
		$this->assertTrue(isset($result['bool']));
	}

	public function test_fromClass_shouldIncludeBlobField_whenDeclaredInConstructor(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithBlobField::class);

		$result = $sut->fields;

		$this->assertSame(2, \count($result));
		$this->assertTrue(isset($result['id']));
		$this->assertTrue(isset($result['blob']));
	}

	public function test_fromClass_shouldNotContainExcludedFields(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithExcludedField::class);

		$result = $sut->fields;

		$this->assertSame(2, \count($result));
		$this->assertTrue(isset($result['id']));
		$this->assertTrue(isset($result['included']));
		$this->assertFalse(isset($result['excluded']));
	}

	public function test_fromClass_shouldFindAllFields_whenCalledWithNonEntity(): void {
		$sut = Schema::fromClass(SchemaTest\NonEntity::class);

		$result = $sut->fields;

		$this->assertSame(4, \count($result));
		$this->assertTrue(isset($result['name']));
		$this->assertTrue(isset($result['factor']));
		$this->assertTrue(isset($result['count']));
		$this->assertTrue(isset($result['flag']));
	}

	public function test_fromClass_shouldThrow_whenEntityDoesNotDefineIdAsField(): void {
		// Arrange
		$sut = Schema::fromClass(SchemaTest\EntityWithIdPropertyWithoutIdParameter::class);

		// Assert
		$this->expectException(Schema\DefinitionException::class);

		// Act
		$_ = $sut->fields;
	}

	public function test_fromClass_shouldPreferStaticConstructorMethodOverRegularConstructor(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithStaticConstructor::class);

		$result = $sut->fields;

		$this->assertSame(2, \count($result));
		$this->assertTrue(isset($result['id']));
		$this->assertTrue(isset($result['overrideName']));
		$this->assertFalse(isset($result['originalName']));
	}

	public function test_fields_shouldRenameFields_whenDeclaredWithFieldNameAttribute(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithRenamedField::class);

		$result = $sut->fields;

		$this->assertSame(2, \count($result));
		$this->assertTrue(isset($result['id']));
		$this->assertTrue(isset($result['alternativeName']));
	}

	public function test_fields_shouldThrow_whenSettingOffset(): void {
		// Arrange
		$sut = Schema::fromClass(SchemaTest\EntityWithScalarFields::class)->fields;

		// Assert
		$this->expectException(Exception::class);

		// Act
		$sut['test'] = 1;
	}

	public function test_fields_shouldThrow_whenUnsettingOffset(): void {
		// Arrange
		$sut = Schema::fromClass(SchemaTest\EntityWithScalarFields::class)->fields;

		// Assert
		$this->expectException(Exception::class);

		// Act
		unset($sut['string']);
	}

	public function test_fields_getIterator_shouldNotThrow(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithScalarFields::class)->fields;

		$count = 0;
		foreach ($sut as $name => $field) {
			$this->assertIsString($name);
			$this->assertInstanceOf(Schema\Field::class, $field);
			$this->assertSame($name, $field->name);
			$count += 1;
		}

		$this->assertSame(5, $count);
	}

	public function test_fields_getIterator_shouldUseRealFieldNameAsKey_whenFieldWasRenamed(): void {
		// Arrange
		$sut = Schema::fromClass(SchemaTest\EntityWithRenamedField::class)->fields;

		// Act
		foreach ($sut as $name => $field) {
			// Assert
			$this->assertSame($name, $field->name);
		}
	}

	public function test_fields_shouldNotContainId_whenNonEntity(): void {
		$sut = Schema::fromClass(SchemaTest\EmptyObject::class);

		$result = $sut->fields;

		$this->assertFalse(isset($result['id']));
	}

	public function test_fields_shouldContainIdField_whenGenericObjectDeclaresIdField(): void {
		$sut = Schema::fromClass(SchemaTest\ObjectWithIdField::class);

		$result = $sut->fields;

		$this->assertTrue(isset($result['id']));
	}

	public function test_fields_shouldThrow_whenOffsetDoesNotExist(): void {
		// Arrange
		$sut = Schema::fromClass(SchemaTest\EmptyEntity::class);

		// Assert
		$this->expectException(OutOfBoundsException::class);

		// Act
		$_ = $sut->fields['does_not_exist'];
	}

	public function test_fields_shouldReturnField_whenOffsetExists(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithScalarFields::class);

		$result = $sut->fields['string'];

		$this->assertInstanceOf(Schema\Field::class, $result);
	}

	public function test_fields_shouldHaveIdWithSequentialValueType_whenEntityDeclaresOne(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithSequentialId::class);

		$result = Schema\TypeInfo::getSerializeType($sut->fields['id']->type::class); // @phpstan-ignore property.nonObject (the field will be found)

		$this->assertSame(SequentialValue::class, $result);
	}

	public function test_fields_shouldHaveIdWithUniqueIdentifierType_whenEntityDeclaresOne(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithUniqueId::class);

		$result = Schema\TypeInfo::getSerializeType($sut->fields['id']->type::class); // @phpstan-ignore property.nonObject (the field will be found)

		$this->assertSame(UniqueIdentifier::class, $result);
	}

}
