<?php

namespace Slendium\OcdTests\Unit\Schema;

use DateTimeInterface;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\Blob;
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

	public static function getSerializeTypeValidCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ TypeInfoTest\BlobType::class, Blob::class ];
		yield [ TypeInfoTest\NullableBlobType::class, Blob::class ];
		yield [ TypeInfoTest\DateTimeInterfaceType::class, DateTimeInterface::class ];
		yield [ TypeInfoTest\NullableDateTimeInterfaceType::class, DateTimeInterface::class ];
		yield [ TypeInfoTest\ArrayType::class, 'array' ];
		yield [ TypeInfoTest\NullableArrayType::class, 'array' ];
		yield [ TypeInfoTest\StringType::class, 'string' ];
		yield [ TypeInfoTest\ErrorableStringType::class, 'string' ];
		yield [ TypeInfoTest\NullableStringType::class, 'string' ];
		yield [ TypeInfoTest\NullableErrorableStringType::class, 'string' ];
		yield [ TypeInfoTest\FloatType::class, 'float' ];
		yield [ TypeInfoTest\NullableFloatType::class, 'float' ];
		yield [ TypeInfoTest\IntType::class, 'int' ];
		yield [ TypeInfoTest\NullableIntType::class, 'int' ];
		yield [ TypeInfoTest\BoolType::class, 'bool' ];
		yield [ TypeInfoTest\NullableBoolType::class, 'bool' ];
	}

	/** @param class-string<Type> $typeClass */
	#[DataProvider('getSerializeTypeValidCases')]
	public function test_getSerializeType_shouldReturnExpectedResult(string $typeClass, string $expectedResult): void {
		// Act
		$result = TypeInfo::getSerializeType($typeClass);

		// Assert
		$this->assertSame($expectedResult, $result);
	}

	public static function getSerializeTypeInvalidCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ TypeInfoTest\DualUnionType::class ];
		yield [ TypeInfoTest\IterableType::class ];
		yield [ TypeInfoTest\NullType::class ];
		yield [ TypeInfoTest\TooManyTypes::class ];
		yield [ TypeInfoTest\IntersectionType::class ];
		yield [ TypeInfoTest\IntersectionUnionType::class ];
	}

	/** @param class-string<Type> $typeClass */
	#[DataProvider('getSerializeTypeInvalidCases')]
	public function test_getSerializeType_shouldThrow_whenGivenInvalidClass(string $typeClass): void {
		// Assert
		$this->expectException(TypeException::class);

		// Act
		$_ = TypeInfo::getSerializeType($typeClass);
	}

}
