<?php

namespace Slendium\OcdTests\Unit\Query;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Query\DocumentUpdate as U;
use Slendium\Ocd\Query\Update;
use Slendium\Ocd\Query\ValuePath;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DocumentUpdateTest extends TestCase {

	public function test_create_shouldConvertLiteralsToSetUpdates(): void {
		$expectedField = 'test';
		$expectedValue = 'literal string';

		$result = U::create([ $expectedField => $expectedValue ]);

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Update\Set::class, $result[0]);
		$this->assertSame([ $expectedField ], $result[0]->path->fieldPath);
		$this->assertSame($expectedValue, $result[0]->value);
	}

	public function test_create_shouldFlattenClosureResult(): void {
		$baseField = 'test';
		$closure = static fn(ValuePath $field) => [
			new Update\Set(new ValuePath([ ...$field->fieldPath, 'inner1' ]), 10),
			new Update\Set(new ValuePath([ ...$field->fieldPath, 'inner2' ]), 20)
		];

		$result = U::create([ $baseField => $closure ]);

		$this->assertSame(2, \count($result));
		foreach ($result as $update) {
			$this->assertInstanceOf(Update\Set::class, $update);
			$this->assertSame(2, \count($update->path->fieldPath));
			$this->assertSame($baseField, $update->path->fieldPath[0]);
		}
	}

	public function test_create_shouldYieldValuePathsWithInnerPath_whenUsedWithInnerValueMethod(): void {
		$field = 'foo';
		$innerPath = [ 'bar', 'baz' ];
		$setValue = '801ca6e0-e872-4312-b9b1-e0e5d37d5055';

		$result = U::create([ $field => U::innerValue($innerPath, U::set($setValue)) ]);

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Update\Set::class, $result[0]);
		$this->assertSame([ $field ], $result[0]->path->fieldPath);
		$this->assertSame($innerPath, $result[0]->path->innerPath);
		$this->assertSame($setValue, $result[0]->value);
	}

	public function test_set_shouldResultInExpectedUpdate(): void {
		$expectedField = 'test';
		$expectedValue = true;
		$sut = U::set($expectedValue);

		$result = \iterator_to_array($sut(new ValuePath([ $expectedField ])));

		$this->assertSame(1, \count($result));
		$this->assertSame([ $expectedField ], $result[0]->path->fieldPath);
		$this->assertSame($expectedValue, $result[0]->value);
	}

	public function test_unset_shouldResultInExpectedUpdate(): void {
		$expectedField = 'test';
		$sut = U::unset();

		$result = \iterator_to_array($sut(new ValuePath([ $expectedField ])));

		$this->assertSame(1, \count($result));
		$this->assertSame([ $expectedField ], $result[0]->path->fieldPath);
	}

	public function test_add_shouldResultInExpectedUpdate(): void {
		$expectedField = 'test';
		$expectedAmount = -1;
		$sut = U::add($expectedAmount);

		$result = \iterator_to_array($sut(new ValuePath([ $expectedField ])));

		$this->assertSame(1, \count($result));
		$this->assertSame([ $expectedField ], $result[0]->path->fieldPath);
		$this->assertSame($expectedAmount, $result[0]->amount);
	}

	public function test_multiply_shouldResultInExpectedUpdate(): void {
		$expectedField = 'test';
		$expectedAmount = 0.25;
		$sut = U::multiply($expectedAmount);

		$result = \iterator_to_array($sut(new ValuePath([ $expectedField ])));

		$this->assertSame(1, \count($result));
		$this->assertSame([ $expectedField ], $result[0]->path->fieldPath);
		$this->assertSame($expectedAmount, $result[0]->amount);
	}

	public function test_append_shouldResultInExpectedUpdate(): void {
		$expectedPath = [ 'test', 'inner' ];
		$expectedValue = 999;
		$sut = U::append($expectedValue);

		$result = \iterator_to_array($sut(new ValuePath($expectedPath)));

		$this->assertSame(1, \count($result));
		$this->assertSame($expectedPath, $result[0]->path->fieldPath);
		$this->assertSame($expectedValue, $result[0]->value);
	}

	public function test_multiple_shouldYieldMultipleClosureResults(): void {
		$expectedField = 'test';
		$sut = U::multiple(U::set(10), U::add(1));

		$result = 0;
		foreach ($sut(new ValuePath([ $expectedField ])) as $_) {
			$result += 1;
		}

		$this->assertSame(2, $result);
	}

	public function test_if_shouldYieldNoResults_whenConditionIsFalseAndNoElseBranchGiven(): void {
		$sut = U::if(false, U::add(1));

		$result = \iterator_to_array($sut(new ValuePath([ 'test' ])));

		$this->assertEmpty($result);
	}

	public function test_if_shouldYieldElseResults_whenConditionIsFalseAndElseBranchGiven(): void {
		$sut = U::if(false, then: U::add(1), else: U::add(-1));

		$result = \iterator_to_array($sut(new ValuePath([ 'test' ])));

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Update\Add::class, $result[0]);
		$this->assertSame(-1, $result[0]->amount);
	}

	public function test_if_shouldYieldResults_whenConditionIsTrue(): void {
		$sut = U::if(true, U::add(1));

		$result = \iterator_to_array($sut(new ValuePath([ 'test' ])));

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Update\Add::class, $result[0]);
	}

}
