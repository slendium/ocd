<?php

namespace Slendium\OcdTests\Unit;

use Throwable;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Entity\SequentialValue;
use Slendium\Ocd\Entity\UniqueIdentifier;
use Slendium\Ocd\Schema;
use Slendium\OcdTests\Common\Entities as TestEntities;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SchemaTest extends TestCase {

	public static function definitionExceptionCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ SchemaTest\EntityThatExcludesId::class ];
		yield [ SchemaTest\EntityWithIdPropertyWithoutIdParameter::class ];

		foreach (TestEntities::getAllInvalidClasses() as $class) {
			yield [ $class ];
		}
	}

	/** @param class-string $class */
	#[DataProvider('definitionExceptionCases')]
	public function test_fromClass_shouldThrow_whenClassDefinesInvalidSchema(string $class): void {
		// Arrange
		$sut = Schema::fromClass($class);

		// Assert
		$this->expectException(Schema\DefinitionException::class);

		// Act
		$_ = $sut->fields; // triggers lazy instantiation
	}

	public function test_fromClass_shouldIgnoreCustomPrimaryField_whenEntityGiven(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithPrimaryOverride::class);

		$result = $sut->primaries;

		$this->assertSame(1, \count($result));
		$this->assertSame('id', $result[0]->name);
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

	public function test_fromClass_shouldPreferStaticConstructorMethodOverRegularConstructor(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithStaticConstructor::class);

		$result = $sut->fields;

		$this->assertSame(2, \count($result));
		$this->assertTrue(isset($result['id']));
		$this->assertTrue(isset($result['overrideName']));
		$this->assertFalse(isset($result['originalName']));
	}

	public function test_fromClass_shouldFindAllIndexes(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithIndexes::class);

		$result = \array_map(fn($idx) => $idx->fields, $sut->indexes);

		$this->assertSame(3, \count($result));
		$this->assertEqualsCanonicalizing(SchemaTest\EntityWithIndexes::EXPECTED_INDEXES, $result);
	}

	public function test_fromClass_shouldAddImpliedIdPrimary_whenEntityGiven(): void {
		$sut = Schema::fromClass(SchemaTest\EmptyEntity::class);

		$result = $sut->primaries;

		$this->assertSame(1, \count($result));
		$this->assertSame('id', $result[0]->name);
	}

	public function test_fromClass_shouldFindAllPrimaries(): void {
		$sut = Schema::fromClass(SchemaTest\ObjectWithPrimaryFields::class);

		$result = \array_map(fn($pri) => $pri->name, $sut->primaries);

		$this->assertSame(2, \count($result));
		$this->assertEqualsCanonicalizing(SchemaTest\ObjectWithPrimaryFields::EXPECTED_PRIMARIES, $result);
	}

	public function test_fromClass_shouldFindAllDeclaredConstraints(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithExplicitConstraints::class);

		$result = $sut->constraints;
		$invariants = \array_filter($result, fn($c) => $c instanceof Schema\Constraint\Invariant);
		$uniques = \array_filter($result, fn($c) => $c instanceof Schema\Constraint\Unique);
		$references = \array_filter($result, fn($c) => $c instanceof Schema\Constraint\Reference);

		$this->assertSame(SchemaTest\EntityWithExplicitConstraints::EXPECTED_INVARIANTS, \count($invariants));
		$this->assertSame(SchemaTest\EntityWithExplicitConstraints::EXPECTED_UNIQUES, \count($uniques));
		$this->assertSame(SchemaTest\EntityWithExplicitConstraints::EXPECTED_REFERENCES, \count($references));
		$this->assertSame(SchemaTest\EntityWithExplicitConstraints::EXPECTED_CONSTRAINTS, \count($result));
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

	public function test_fields_shouldReturnField_whenOffsetExists(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithScalarFields::class);

		$result = $sut->fields['string'];

		$this->assertInstanceOf(Schema\Field::class, $result);
	}

	public function test_fields_shouldHaveIdWithSequentialValueType_whenEntityDeclaresOne(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithSequentialId::class);

		$result = Schema\TypeInfo::getSerializeType($sut->fields['id']->type::class);

		$this->assertSame(SequentialValue::class, $result);
	}

	public function test_fields_shouldHaveIdWithUniqueIdentifierType_whenEntityDeclaresOne(): void {
		$sut = Schema::fromClass(SchemaTest\EntityWithUniqueId::class);

		$result = Schema\TypeInfo::getSerializeType($sut->fields['id']->type::class);

		$this->assertSame(UniqueIdentifier::class, $result);
	}

}
