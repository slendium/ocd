<?php

namespace Slendium\OcdTests\Unit\Predicate;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Predicate;
use Slendium\Ocd\Predicate\DocumentShape as Q;
use Slendium\Ocd\Predicate\Expr;
use Slendium\Ocd\Schema\StorageClass;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DocumentShapeTest extends TestCase {

	public function test_shape_shouldEvaluateClosuresImmediately(): void {
		$field = 'test';
		$rhs = 5;
		$shape = [ $field => static fn(FieldPath $path) => new Expr\GreaterThanOrEqual($path, $rhs) ];

		$result = Q::shape($shape);

		$this->assertSame(1, \count($result->inputs));
		$this->assertInstanceOf(Expr\GreaterThanOrEqual::class, $result->inputs[0]);
		$this->assertInstanceOf(FieldPath::class, $result->inputs[0]->lhs);
		$this->assertSame([ $field ], $result->inputs[0]->lhs->path);
		$this->assertSame($rhs, $result->inputs[0]->rhs);
	}

	public function test_shape_shouldEvaluateNonClosureAsEqualsExpr(): void {
		$shape = [
			'string' => 'string',
			'int' => 10,
			'float' => 1.5,
			'bool' => true,
			'null' => null
		];

		$result = Q::shape($shape);

		$this->assertSame(5, \count($result->inputs));
		foreach ($result->inputs as $expr) {
			$this->assertInstanceOf(Expr\Equal::class, $expr);
			$this->assertInstanceOf(FieldPath::class, $expr->lhs);
			$this->assertSame($shape[$expr->lhs->path[0]], $expr->rhs);
		}
	}

	public function test_and_shouldEvaluateAsNestedShape(): void {
		$and = [
			'positive' => static fn(FieldPath $path) => new Expr\GreaterThan($path, 0),
			'string' => 'string',
			'int' => -5,
			'float' => 1.0,
			'bool' => false,
			'null' => null
		];

		$result = Q::shape([ 'test' => Q::and($and) ]);

		$this->assertInstanceOf(Expr\And_::class, $result->inputs[0]);
		$this->assertSame(6, \count($result->inputs[0]->inputs));
		foreach ($result->inputs[0]->inputs as $expr) {
			if ($expr instanceof Expr\Equal || $expr instanceof Expr\GreaterThan) {
				$this->assertInstanceOf(FieldPath::class, $expr->lhs);
				$this->assertSame(2, \count($expr->lhs->path));
			}
		}
	}

	public function test_or_shouldEvaluateAsNestedShape(): void {
		$or = [
			'positive' => static fn(FieldPath $path) => new Expr\GreaterThan($path, 0),
			'string' => 'string',
			'int' => -5,
			'float' => 1.0,
			'bool' => false,
			'null' => null
		];

		$result = Q::shape([ 'test' => Q::or($or) ]);

		$this->assertInstanceOf(Expr\Or_::class, $result->inputs[0]);
		foreach ($result->inputs[0]->inputs as $expr) {
			if ($expr instanceof Expr\Equal || $expr instanceof Expr\GreaterThan) {
				$this->assertInstanceOf(FieldPath::class, $expr->lhs);
				$this->assertSame(2, \count($expr->lhs->path));
			}
		}
	}

	public function test_eq_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = true;
		$sut = Q::eq($rhsValue);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_notEqual_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = 5;
		$sut = Q::notEqual($rhsValue);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_gt_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = 1;
		$sut = Q::gt($rhsValue);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_gte_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = -3;
		$sut = Q::gte($rhsValue);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_lt_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = 99;
		$sut = Q::lt($rhsValue);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_lte_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = 42;
		$sut = Q::lte($rhsValue);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_matchAll_shouldProduceValidPredicate(): void {
		$expectedResult = [ 1, 2, 3 ];
		$field = 'test';
		$sut = Q::matchAll($expectedResult);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertSame([ $field ], $result->field->path);
		$this->assertSame($expectedResult, $result->values);
	}

	public function test_matchSome_shouldProduceValidPredicate(): void {
		$expectedResult = [ 'a', 'b', 'c' ];
		$field = 'test';
		$sut = Q::matchSome($expectedResult);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertSame([ $field ], $result->field->path);
		$this->assertSame($expectedResult, $result->values);
	}

	public function test_matchNone_shouldProduceValidPredicate(): void {
		$expectedResult = [ 0, true, null ];
		$field = 'test';
		$sut = Q::matchNone($expectedResult);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertSame([ $field ], $result->field->path);
		$this->assertSame($expectedResult, $result->values);
	}

	public function test_regex_shouldProduceValidPredicate(): void {
		$expectedResult = '^pen';
		$field = 'test';
		$sut = Q::regex($expectedResult);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertSame([ $field ], $result->field->path);
		$this->assertSame($expectedResult, $result->regex);
	}

	public function test_isEmpty_shouldProduceValidPredicate(): void {
		$sut = Q::isEmpty();
		$field = 'test';
		$checkNotExists = false;

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(Expr\Or_::class, $result);
		foreach ($result->inputs as $expr) {
			if ($expr instanceof Expr\NotExists) {
				$checkNotExists = true;
				$this->assertSame([ $field ], $expr->field->path);
			} else if ($expr instanceof Expr\MatchSome) {
				$this->assertSame([ $field ], $expr->field->path);
				$this->assertContains('', $expr->values);
				$this->assertContains(null, $expr->values);
			}
		}
		$this->assertTrue($checkNotExists);
	}

	public function test_isNonEmpty_shouldProduceValidPredicate(): void {
		$sut = Q::isNonEmpty();
		$field = 'test';
		$checkExists = false;

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(Expr\And_::class, $result);
		foreach ($result->inputs as $expr) {
			if ($expr instanceof Expr\Exists) {
				$checkExists = true;
				$this->assertSame([ $field ], $expr->field->path);
			} else if ($expr instanceof Expr\MatchNone) {
				$this->assertSame([ $field ], $expr->field->path);
				$this->assertContains('', $expr->values);
				$this->assertContains(null, $expr->values);
			}
		}
		$this->assertTrue($checkExists);
	}

	public function test_isOfType_shouldProduceValidPredicate(): void {
		$expectedStorageClass = StorageClass::String;
		$field = 'test';
		$sut = Q::isOfType($expectedStorageClass);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertSame([ $field ], $result->field->path);
		$this->assertSame($expectedStorageClass, $result->storageClass);
	}

	public function test_isNotOfType_shouldProduceValidPredicate(): void {
		$expectedStorageClass = StorageClass::String;
		$field = 'test';
		$sut = Q::isNotOfType($expectedStorageClass);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertSame([ $field ], $result->field->path);
		$this->assertSame($expectedStorageClass, $result->storageClass);
	}

	public function test_path_shouldProduceMergedPath(): void {
		$topLevelPart = 'test';
		$topLevelField = new FieldPath([ $topLevelPart ]);
		$part1 = 'inner1';
		$part2 = 'inner2';
		$expectedPath = [ $topLevelPart, $part1, $part2 ];
		$resultPath = null;
		$sut = Q::path([ $part1, $part2 ], static function($field) use (&$resultPath) {
			$resultPath = $field->path;
			return new Expr\Exists($field);
		});

		$result = $sut($topLevelField);

		$this->assertInstanceOf(Expr\Exists::class, $result);
		$this->assertSame($expectedPath, $result->field->path);
	}

	public function test_field_shouldReturnSameInstance_whenInvokedWithInstance(): void {
		$expectedResult = new FieldPath([ 'test' ]);

		$result = Q::field($expectedResult);

		$this->assertSame($expectedResult, $result);
	}

	public function test_field_shouldReturnExpectedResult_whenInvokedWithString(): void {
		$field = 'test';

		$result = Q::field($field);

		$this->assertSame(1, \count($result->path));
		$this->assertSame($field, $result->path[0]);
	}

	public function test_field_shouldReturnExpectedResult_whenInvokedWithArray(): void {
		$field = [ 'test', 'inner' ];

		$result = Q::field($field);

		$this->assertSame($field, $result->path);
	}

}
