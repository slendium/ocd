<?php

namespace Slendium\OcdTests\Unit\Entity;

use RuntimeException;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\PartialObject;
use Slendium\Ocd\Document\MutableDocument;
use Slendium\Ocd\Entity\SchemaAssembler;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SchemaAssemblerTest extends TestCase {

	public function test_assemble_shouldRespectFromDocumentInterface(): void {
		$sut = new SchemaAssembler;
		$expectedName = '00351d53-0e68-44ff-adcd-b60c85b4f539';
		$doc = new MutableDocument([ 'name' => $expectedName ]);

		$result = $sut->assemble($doc, SchemaAssemblerTest\DocumentConvertibleEntity::class);

		$this->assertTrue($result->staticallyConstructed);
		$this->assertSame($expectedName, $result->name);
	}

	public function test_assemble_shouldDirectlyConstructEntity_whenNoMethodDeclared(): void {
		$sut = new SchemaAssembler;
		$doc = new MutableDocument;

		$result = $sut->assemble($doc, SchemaAssemblerTest\ConstructorlessEntity::class);

		$this->assertSame(SchemaAssemblerTest\ConstructorlessEntity::FIXED_ID, $result->id);
	}

	public static function fieldValueCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ [ 'id' => '1' ], SchemaAssemblerTest\EntityWithNullableField::class, null ];
		yield [ [ 'id' => '1' ], SchemaAssemblerTest\EntityWithNullableDefaultableField::class, SchemaAssemblerTest\EntityWithNullableDefaultableField::FIELD_DEFAULT ];
		yield [ [ 'id' => '1', 'field' => null ], SchemaAssemblerTest\EntityWithNullableDefaultableField::class, SchemaAssemblerTest\EntityWithNullableDefaultableField::FIELD_DEFAULT ];
		yield [ [ 'id' => '1' ], SchemaAssemblerTest\EntityWithTypeDefaultStringField::class, SchemaAssemblerTest\EntityWithTypeDefaultStringField::FIELD_TYPE_DEFAULT ];

		$fieldValue = 'a6fda733-13ee-4e7a-90b9-b2c9d351403d';
		yield [ [ 'id' => '1', 'field' => $fieldValue ], SchemaAssemblerTest\EntityWithStringField::class, $fieldValue ];

		$fieldValue = '445553a4-fc2f-4488-89f9-679667346818';
		yield [ [ 'id' => '1', 'field' => $fieldValue ], SchemaAssemblerTest\EntityFromFields::class, $fieldValue ];
	}

	/**
	 * @param array<non-empty-string,mixed> $doc
	 * @param class-string $entity
	 */
	#[DataProvider('fieldValueCases')]
	public function test_assemble_shouldSetFieldToExpectedResult(array $doc, string $entity, mixed $expectedResult): void {
		$doc = new MutableDocument($doc);
		$sut = new SchemaAssembler;

		$result = $sut->assemble($doc, $entity)->field; // @phpstan-ignore property.notFound

		$this->assertSame($expectedResult, $result);
	}

	public function test_assemble_shouldCreatePartialObjectInPlaceOfEntityReference(): void {
		// Arrange
		$referenceId = '7a5eb8f7-8533-40cf-a5d1-c7bcbb5a81db';
		$doc = new MutableDocument([ 'id' => '1', 'ref' => $referenceId ]);
		$sut = new SchemaAssembler;

		// Act
		$result = $sut->assemble($doc, SchemaAssemblerTest\EntityWithEntityReference::class);

		// Assert
		$this->assertTrue(PartialObject::isPartial($result->ref));
		$this->assertSame($referenceId, $result->ref->id);
		$this->expectException(RuntimeException::class);

		// Act (should throw)
		$_ = $result->ref->name;
	}

	public function test_assemble_shouldCreatePartialObjectInPlaceOfObjectReference(): void {
		// Arrange
		$referenceId = '58083dda-48ff-42da-bd0a-932a9caf2d45';
		$doc = new MutableDocument([ 'id' => '1', 'ref' => $referenceId ]);
		$sut = new SchemaAssembler;

		// Act
		$result = $sut->assemble($doc, SchemaAssemblerTest\EntityWithObjectReference::class);

		// Assert
		$this->assertTrue(PartialObject::isPartial($result->ref));
		$this->assertSame($referenceId, $result->ref->code);
		$this->expectException(RuntimeException::class);

		// Act (should throw)
		$_ = $result->ref->name;
	}

	public function test_assemble_shouldConstructReference_whenSubDocument(): void {
		$expectedName = 'dbce0356-64cc-48db-b949-b2becb2abd13';
		$doc = new MutableDocument([
			'id' => '1',
			'ref' => new MutableDocument([ 'id' => '2', 'name' => $expectedName ])
		]);
		$sut = new SchemaAssembler;

		$result = $sut->assemble($doc, SchemaAssemblerTest\EntityWithEntityReference::class);

		$this->assertFalse(PartialObject::isPartial($result->ref));
		$this->assertSame($expectedName, $result->ref->name);
	}

}
