<?php

namespace Slendium\OcdTests\Unit\Document;

use Exception;
use OutOfBoundsException;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Document\MutableDocument;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class MutableDocumentTest extends TestCase {

	public function test___construct_shouldAllowInitialValues(): void {
		$field = 'test';
		$expectedValue = 10;
		$values = [ $field => $expectedValue ];

		$sut = new MutableDocument($values);

		$this->assertSame(1, \count($sut));
		$this->assertSame($expectedValue, $sut[$field]);
	}

	public function test_offsetExists_shouldReturnExpectedResult(): void {
		$field = 'test';
		$value = 10;
		$sut = new MutableDocument([ $field => $value ]);

		$resultTrue = isset($sut[$field]);
		$resultFalse = isset($sut['does-not-exist']);

		$this->assertTrue($resultTrue);
		$this->assertFalse($resultFalse);
	}

	public function test_offsetGet_shouldReturnExpectedResult(): void {
		$field = 'test';
		$value = '012864ee-515c-47d9-8241-9674baa237ad';
		$sut = new MutableDocument([ $field => $value ]);

		$result = $sut[$field];

		$this->assertSame($value, $result);
	}

	public function test_offsetGet_shouldThrow_whenOffsetDoesNotExist(): void {
		// Arrange
		$sut = new MutableDocument;

		// Assert
		$this->expectException(OutOfBoundsException::class);

		// Act
		$_ = $sut['does-not-exist'];
	}

	public function test_offsetSet_shouldAffectDocument(): void {
		$field = 'test';
		$value = '1d2b3cdf-8def-47ed-b3f2-cc0f93e43628';
		$sut = new MutableDocument;

		$sut[$field] = $value;

		$this->assertTrue(isset($sut[$field]));
		$this->assertSame($value, $sut[$field]);
	}

	public function test_offsetSet_shouldThrow_whenOffsetIsNull(): void {
		// Arrange
		$sut = new MutableDocument;

		// Assert
		$this->expectException(Exception::class);

		// Act
		$sut[] = '71a0c407-f5d4-42e1-9a93-2860dbbf9c6b';
	}

	public function test_offsetUnset_shouldAffectDocument(): void {
		$field = 'test';
		$value = '967f3c07-d590-43ba-8b7e-aae1a385ab5f';
		$sut = new MutableDocument([ $field => $value ]);

		unset($sut[$field]);

		$this->assertFalse(isset($sut[$field]));
	}

	public function test_count_shouldReflectIterations(): void {
		// Arrange
		$values = [
			'test1' => '3190f1d8-efb2-4bc5-a5e3-4cace088aade',
			'test2' => 'e8a42021-4e42-4def-b1e5-04eae38d49ae',
			'test3' => 'ed7d1a76-03a7-415b-9e86-760aecbd58f6'
		];
		$sut = new MutableDocument($values);

		// Act
		$result = \count($sut);
		$iterations = 0;
		foreach ($sut as $field => $_) {
			$iterations += 1;
			// Assert
			$this->assertTrue(isset($values[$field]));
		}

		// Assert
		$this->assertSame(\count($values), $result);
		$this->assertSame(\count($values), $iterations);
	}

}
