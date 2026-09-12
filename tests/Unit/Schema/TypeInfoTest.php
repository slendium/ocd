<?php

namespace Slendium\OcdTests\Unit\Schema;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\StorageClass;
use Slendium\Ocd\Schema\Type;
use Slendium\Ocd\Schema\TypeException;
use Slendium\Ocd\Schema\TypeInfo;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class TypeInfoTest extends TestCase {

	public static function getStorageClassValidCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ TypeInfoTest\BlobType::class, StorageClass::Binary ];
		yield [ TypeInfoTest\NullableBlobType::class, StorageClass::Binary ];
		yield [ TypeInfoTest\StringType::class, StorageClass::String ];
		yield [ TypeInfoTest\NullableStringType::class, StorageClass::String ];
		yield [ TypeInfoTest\FloatType::class, StorageClass::Float ];
		yield [ TypeInfoTest\NullableFloatType::class, StorageClass::Float ];
		yield [ TypeInfoTest\IntType::class, StorageClass::Int ];
		yield [ TypeInfoTest\NullableIntType::class, StorageClass::Int ];
		yield [ TypeInfoTest\BoolType::class, StorageClass::Bool ];
		yield [ TypeInfoTest\NullableBoolType::class, StorageClass::Bool ];
	}

	/** @param class-string<Type> $typeClass */
	#[DataProvider('getStorageClassValidCases')]
	public function test_getStorageClass_shouldReturnExpectedResult(string $typeClass, StorageClass $expectedResult): void {
		// Act
		$result = TypeInfo::getStorageClass($typeClass);

		// Assert
		$this->assertSame($expectedResult, $result);
	}

	public static function getStorageClassInvalidCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ TypeInfoTest\UnionType::class ];
		yield [ TypeInfoTest\NullType::class ];
	}

	/** @param class-string<Type> $typeClass */
	#[DataProvider('getStorageClassInvalidCases')]
	public function test_getStorageClass_shouldThrow_whenGivenInvalidClass(string $typeClass): void {
		// Assert
		$this->expectException(TypeException::class);

		// Act
		$_ = TypeInfo::getStorageClass($typeClass);
	}

}
