<?php

namespace Slendium\OcdTests\Unit\Query;

use DateTime;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Common\FieldPath;
use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\DocumentShape as Q;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DocumentShapeTest extends TestCase {

	public function test_shape_shouldEvaluateClosuresImmediately(): void {
		$field = 'test';
		$rhs = 5;
		$shape = [ $field => static fn(FieldPath $path) => new Predicate\GreaterThanOrEqual($path, $rhs) ];

		$result = Q::shape($shape);

		$this->assertSame(1, \count($result->inputs));
		$this->assertInstanceOf(Predicate\GreaterThanOrEqual::class, $result->inputs[0]);
		$this->assertInstanceOf(FieldPath::class, $result->inputs[0]->lhs);
		$this->assertSame([ $field ], $result->inputs[0]->lhs->path);
		$this->assertSame($rhs, $result->inputs[0]->rhs);
	}

	public function test_shape_shouldEvaluateNonClosureAsEqualsPredicate(): void {
		$shape = [
			'string' => 'string',
			'int' => 10,
			'float' => 1.5,
			'bool' => true,
			'null' => null
		];

		$result = Q::shape($shape);

		$this->assertSame(5, \count($result->inputs));
		foreach ($result->inputs as $predicate) {
			$this->assertInstanceOf(Predicate\Equal::class, $predicate);
			$this->assertInstanceOf(FieldPath::class, $predicate->lhs);
			$this->assertSame($shape[$predicate->lhs->path[0]], $predicate->rhs);
		}
	}

	public function test_and_shouldEvaluateAsNestedShape(): void {
		$and = [
			'positive' => static fn(FieldPath $path) => new Predicate\GreaterThan($path, 0),
			'string' => 'string',
			'int' => -5,
			'float' => 1.0,
			'bool' => false,
			'null' => null
		];

		$result = Q::shape([ 'test' => Q::and($and) ]);

		$this->assertInstanceOf(Predicate\And_::class, $result->inputs[0]);
		$this->assertSame(6, \count($result->inputs[0]->inputs));
		foreach ($result->inputs[0]->inputs as $predicate) {
			if ($predicate instanceof Predicate\Equal || $predicate instanceof Predicate\GreaterThan) {
				$this->assertInstanceOf(FieldPath::class, $predicate->lhs);
				$this->assertSame(2, \count($predicate->lhs->path));
			}
		}
	}

	public function test_or_shouldEvaluateAsNestedShape(): void {
		$or = [
			'positive' => static fn(FieldPath $path) => new Predicate\GreaterThan($path, 0),
			'string' => 'string',
			'int' => -5,
			'float' => 1.0,
			'bool' => false,
			'null' => null
		];

		$result = Q::shape([ 'test' => Q::or($or) ]);

		$this->assertInstanceOf(Predicate\Or_::class, $result->inputs[0]);
		foreach ($result->inputs[0]->inputs as $predicate) {
			if ($predicate instanceof Predicate\Equal || $predicate instanceof Predicate\GreaterThan) {
				$this->assertInstanceOf(FieldPath::class, $predicate->lhs);
				$this->assertSame(2, \count($predicate->lhs->path));
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

		$this->assertInstanceOf(Predicate\Or_::class, $result);
		foreach ($result->inputs as $predicate) {
			if ($predicate instanceof Predicate\NotExists) {
				$checkNotExists = true;
				$this->assertSame([ $field ], $predicate->field->path);
			} else if ($predicate instanceof Predicate\MatchSome) {
				$this->assertSame([ $field ], $predicate->field->path);
				$this->assertContains('', $predicate->values);
				$this->assertContains(null, $predicate->values);
			}
		}
		$this->assertTrue($checkNotExists);
	}

	public function test_isNonEmpty_shouldProduceValidPredicate(): void {
		$sut = Q::isNonEmpty();
		$field = 'test';
		$checkExists = false;

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(Predicate\And_::class, $result);
		foreach ($result->inputs as $predicate) {
			if ($predicate instanceof Predicate\Exists) {
				$checkExists = true;
				$this->assertSame([ $field ], $predicate->field->path);
			} else if ($predicate instanceof Predicate\MatchNone) {
				$this->assertSame([ $field ], $predicate->field->path);
				$this->assertContains('', $predicate->values);
				$this->assertContains(null, $predicate->values);
			}
		}
		$this->assertTrue($checkExists);
	}

	public function test_before_shouldProduceValidPredicate(): void {
		$expectedResult = new DateTime;
		$field = 'foo';
		$sut = Q::before($expectedResult);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($expectedResult, $result->rhs);
	}

	public function test_onOrBefore_shouldProduceValidPredicate(): void {
		$expectedResult = new DateTime;
		$field = 'foo';
		$sut = Q::onOrBefore($expectedResult);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($expectedResult, $result->rhs);
	}

	public function test_after_shouldProduceValidPredicate(): void {
		$expectedResult = new DateTime;
		$field = 'foo';
		$sut = Q::after($expectedResult);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($expectedResult, $result->rhs);
	}

	public function test_onOrAfter_shouldProduceValidPredicate(): void {
		$expectedResult = new DateTime;
		$field = 'foo';
		$sut = Q::onOrAfter($expectedResult);

		$result = $sut(new FieldPath([ $field ]));

		$this->assertInstanceOf(FieldPath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->path);
		$this->assertSame($expectedResult, $result->rhs);
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
			return new Predicate\Exists($field);
		});

		$result = $sut($topLevelField);

		$this->assertInstanceOf(Predicate\Exists::class, $result);
		$this->assertSame($expectedPath, $result->field->path);
	}

	public function test_field_shouldReturnExpectedResult_whenInvokedWithArray(): void {
		$field = [ 'test', 'inner' ];

		$result = Q::field($field);

		$this->assertSame($field, $result->path);
	}

}
