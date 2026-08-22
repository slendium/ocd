<?php

namespace Slendium\OcdTests\Unit\Update;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Update\DocumentUpdate as U;
use Slendium\Ocd\Update\Stmt;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DocumentUpdateTest extends TestCase {

	public function test_create_shouldConvertLiteralsToSetStatements(): void {
		$expectedField = 'test';
		$expectedValue = 'literal string';

		$result = U::create([ $expectedField => $expectedValue ]);

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Stmt\Set::class, $result[0]);
		$this->assertSame([ $expectedField ], $result[0]->field->path);
		$this->assertSame($expectedValue, $result[0]->value);
	}

	public function test_create_shouldFlattenClosureResult(): void {
		$baseField = 'test';
		$closure = static fn(FieldPath $field) => [
			new Stmt\Set(new FieldPath([ ...$field->path, 'inner1' ]), 10),
			new Stmt\Set(new FieldPath([ ...$field->path, 'inner2' ]), 20)
		];

		$result = U::create([ $baseField => $closure ]);

		$this->assertSame(2, \count($result));
		foreach ($result as $stmt) {
			$this->assertInstanceOf(Stmt\Set::class, $stmt);
			$this->assertSame(2, \count($stmt->field->path));
			$this->assertSame($baseField, $stmt->field->path[0]);
		}
	}

	public function test_set_shouldResultInExpectedStatement(): void {
		$expectedField = 'test';
		$expectedValue = true;
		$sut = U::set($expectedValue);

		$result = \iterator_to_array($sut(new FieldPath([ $expectedField ])));

		$this->assertSame(1, \count($result));
		$this->assertSame([ $expectedField ], $result[0]->field->path);
		$this->assertSame($expectedValue, $result[0]->value);
	}

	public function test_unset_shouldResultInExpectedStatement(): void {
		$expectedField = 'test';
		$sut = U::unset();

		$result = \iterator_to_array($sut(new FieldPath([ $expectedField ])));

		$this->assertSame(1, \count($result));
		$this->assertSame([ $expectedField ], $result[0]->field->path);
	}

	public function test_add_shouldResultInExpectedStatement(): void {
		$expectedField = 'test';
		$expectedAmount = -1;
		$sut = U::add($expectedAmount);

		$result = \iterator_to_array($sut(new FieldPath([ $expectedField ])));

		$this->assertSame(1, \count($result));
		$this->assertSame([ $expectedField ], $result[0]->field->path);
		$this->assertSame($expectedAmount, $result[0]->amount);
	}

	public function test_multiply_shouldResultInExpectedStatement(): void {
		$expectedField = 'test';
		$expectedAmount = 0.25;
		$sut = U::multiply($expectedAmount);

		$result = \iterator_to_array($sut(new FieldPath([ $expectedField ])));

		$this->assertSame(1, \count($result));
		$this->assertSame([ $expectedField ], $result[0]->field->path);
		$this->assertSame($expectedAmount, $result[0]->amount);
	}

	public function test_append_shouldResultInExpectedStatement(): void {
		$expectedPath = [ 'test', 'inner' ];
		$expectedValue = 999;
		$sut = U::append($expectedValue);

		$result = \iterator_to_array($sut(new FieldPath($expectedPath)));

		$this->assertSame(1, \count($result));
		$this->assertSame($expectedPath, $result[0]->field->path);
		$this->assertSame($expectedValue, $result[0]->value);
	}

	public function test_multiple_shouldYieldMultipleClosureResults(): void {
		$expectedField = 'test';
		$sut = U::multiple(U::set(10), U::add(1));

		$result = 0;
		foreach ($sut(new FieldPath([ $expectedField ])) as $_) {
			$result += 1;
		}

		$this->assertSame(2, $result);
	}

	public function test_multiple_shouldYieldNestedPaths_whenUsedInConjunctionWithPathMethod(): void {
		$baseField = 'test';
		$nestedField = 'inner';
		$expectedValue = -10;
		$sut = U::multiple(U::path([ $nestedField ], U::set($expectedValue)));

		$result = \iterator_to_array($sut(new FieldPath([ $baseField ])));

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Stmt\Set::class, $result[0]);
		$this->assertSame([ $baseField, $nestedField ], $result[0]->field->path);
		$this->assertSame($expectedValue, $result[0]->value);
	}

	public function test_if_shouldYieldNoResults_whenConditionIsFalseAndNoElseBranchGiven(): void {
		$sut = U::if(false, U::add(1));

		$result = \iterator_to_array($sut(new FieldPath([ 'test' ])));

		$this->assertEmpty($result);
	}

	public function test_if_shouldYieldElseResults_whenConditionIsFalseAndElseBranchGiven(): void {
		$sut = U::if(false, then: U::add(1), else: U::add(-1));

		$result = \iterator_to_array($sut(new FieldPath([ 'test' ])));

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Stmt\Add::class, $result[0]);
		$this->assertSame(-1, $result[0]->amount);
	}

	public function test_if_shouldYieldResults_whenConditionIsTrue(): void {
		$sut = U::if(true, U::add(1));

		$result = \iterator_to_array($sut(new FieldPath([ 'test' ])));

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Stmt\Add::class, $result[0]);
	}

}
