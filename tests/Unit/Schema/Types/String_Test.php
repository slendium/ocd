<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use DateTime;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Type\SerializeException;
use Slendium\Ocd\Schema\Types\String_;
use Slendium\OcdTests\Common\MockStringable;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class String_Test extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$expectedResult = 10;

		$result = new String_(characterLimit: $expectedResult)->characterLimit;

		$this->assertSame($expectedResult, $result);
	}

	public static function serializeCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ null, '' ];
		yield [ '', '' ];
		yield [ '258a11b0-6db2-4315-b083-187f7ea83c5d', '258a11b0-6db2-4315-b083-187f7ea83c5d' ];
		yield [ 0.0, '0' ];
		yield [ 1.25, '1.25' ];
		yield [ -1, '-1' ];
		yield [ 0, '0' ];
		yield [ 1, '1' ];

		$stringableValue = 'fe8155b2-d97f-4811-826f-9ec9d2415e72';
		yield [ new MockStringable($stringableValue), $stringableValue ];
	}

	#[DataProvider('serializeCases')]
	public function test_serialize_shouldProduceExpectedResult(mixed $input, mixed $expectedResult): void {
		$sut = new String_;

		$result = $sut->serialize($input);

		$this->assertSame($expectedResult, $result);
	}

	public static function serializeExceptionCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ 'foo', 1 ];
		yield [ 100, 1 ];
		yield [ 9.75, 1 ];
		yield [ new MockStringable('foo'), 1 ];
		yield [ true, 900 ];
		yield [ false, 900 ];
		yield [ [ ], 900 ];
		yield [ new DateTime, 900 ];
	}

	/** @param int<1,max> $charLimit */
	#[DataProvider('serializeExceptionCases')]
	public function test_serialize_shouldReturnSerializeException(mixed $input, int $charLimit): void {
		$sut = new String_(characterLimit: $charLimit);

		$result = $sut->serialize($input);

		$this->assertInstanceOf(SerializeException::class, $result);
	}

	public static function deserializeCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ null, null ];
		yield [ true, null ];
		yield [ false, null ];
		yield [ [ ], null ];

		yield [ '', '' ];
		$stringValue = '7a7703ba-adf5-4cfa-b044-a0b8aa2054e0';
		yield [ $stringValue, $stringValue ];
		yield [ -1, '-1' ];
		yield [ 0, '0' ];
		yield [ 1, '1' ];
		yield [ 1.25, '1.25' ];

		$stringableValue = '575455c8-b281-42cf-a0fb-fa8b3c24d247';
		yield [ new MockStringable($stringableValue), $stringableValue ];
	}

	#[DataProvider('deserializeCases')]
	public function test_deserializeValue_shouldReturnExpectedResult(mixed $input, mixed $expectedResult): void {
		// Act
		$result = String_::deserializeValue($input);

		// Assert
		$this->assertSame($expectedResult, $result);
	}

	#[DataProvider('deserializeCases')]
	public function test_deserialize_shouldReturnExpectedResult(mixed $input, mixed $expectedResult): void {
		$sut = new String_;

		$result = $sut->deserialize($input);

		$this->assertSame($expectedResult, $result);
	}

	public static function isDefaultSerializeValueCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ null, false ];
		yield [ '', true ];
		yield [ 'edb6bed0-4260-459a-9e2c-19cafe07e344', false ];
	}

	#[DataProvider('isDefaultSerializeValueCases')]
	public function test_isDefaultSerializeValue_shouldReturnExpectedResult(mixed $input, bool $expectedResult): void {
		$sut = new String_;

		$result = $sut->isDefaultSerializeValue($input);

		$this->assertSame($expectedResult, $result);
	}

	public function test_getDefaultSerializeValue_shouldReturnEmptyString(): void {
		$sut = new String_;

		$result = $sut->getDefaultSerializeValue();

		$this->assertSame('', $result);
	}

}
