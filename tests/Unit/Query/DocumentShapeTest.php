<?php

namespace Slendium\OcdTests\Unit\Query;

use Closure;
use DateTime;
use LogicException;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateAggregate;
use Slendium\Ocd\Query\DocumentShape as Q;
use Slendium\Ocd\Query\ValuePath;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DocumentShapeTest extends TestCase {

	public function test_createForId_shouldCreateIdEqualsPredicate(): void {
		$id = 'ab159a27-c293-4759-926e-5caf20a0cef3';

		$result = Q::createForId($id);

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ 'id' ], $result->lhs->fieldPath);
		$this->assertSame([ ], $result->lhs->innerPath);
		$this->assertSame($id, $result->rhs);
	}

	public static function aggregators(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ self::newAnd(...) ];
		yield [ self::newOr(...) ];
	}

	/** @param Closure(non-empty-list<Predicate>):PredicateAggregate $aggregate */
	#[DataProvider('aggregators')]
	public function test_create_shouldProduceExpectedResult(Closure $aggregate): void {
		$expectedEqual = 'string';
		$expectedGte = 0;
		$shape = [
			'equal' => $expectedEqual,
			'gte' => fn(ValuePath $path) => new Predicate\GreaterThanOrEqual($path, $expectedGte)
		];

		$result = Q::create($shape, $aggregate);

		$this->assertSame(2, \count($result->inputs));
		foreach ($result->inputs as $predicate) {
			if ($predicate instanceof Predicate\Equal) {
				$this->assertInstanceOf(ValuePath::class, $predicate->lhs);
				$this->assertSame([ 'equal' ], $predicate->lhs->fieldPath);
				$this->assertSame($expectedEqual, $predicate->rhs);
			} else if ($predicate instanceof Predicate\GreaterThanOrEqual) {
				$this->assertInstanceOf(ValuePath::class, $predicate->lhs);
				$this->assertSame([ 'gte' ], $predicate->lhs->fieldPath);
				$this->assertSame($expectedGte, $predicate->rhs);
			}
		}
	}

	/** @param Closure(non-empty-list<Predicate>):PredicateAggregate $aggregate */
	#[DataProvider('aggregators')]
	public function test_referenceShape_shouldProduceExpectedPredicate(Closure $aggregate): void {
		$expectedEqual = 1;
		$expectedGt = 2;
		$shape = [ 'a' => $expectedEqual, 'b' => fn(ValuePath $path) => new Predicate\GreaterThan($path, $expectedGt) ];
		$fieldPath = [ 'foo' ];
		$path = new ValuePath($fieldPath);

		$result = Q::referenceShape($shape, $aggregate)($path);

		$this->assertSame(\count($shape), \count($result->inputs));
		$this->assertInstanceOf(Predicate\Equal::class, $result->inputs[0]);
		$this->assertInstanceOf(ValuePath::class, $result->inputs[0]->lhs);
		$this->assertSame([ ...$fieldPath, 'a' ], $result->inputs[0]->lhs->fieldPath);
		$this->assertSame([ ], $result->inputs[0]->lhs->innerPath);
		$this->assertSame($expectedEqual, $result->inputs[0]->rhs);
		$this->assertInstanceOf(Predicate\GreaterThan::class, $result->inputs[1]);
		$this->assertInstanceOf(ValuePath::class, $result->inputs[1]->lhs);
		$this->assertSame([ ...$fieldPath, 'b' ], $result->inputs[1]->lhs->fieldPath);
		$this->assertSame([ ], $result->inputs[1]->lhs->innerPath);
		$this->assertSame($expectedGt, $result->inputs[1]->rhs);
	}

	/** @param Closure(non-empty-list<Predicate>):PredicateAggregate $aggregate */
	#[DataProvider('aggregators')]
	public function test_referenceShape_shouldThrow_whenInnerPathNonEmpty(Closure $aggregate): void {
		// Arrange
		$path = new ValuePath([ 'foo' ], [ 'bar' ]);

		// Assert
		$this->expectException(LogicException::class);

		// Act
		$result = Q::referenceShape([ 'a' => 1 ], $aggregate)($path);
	}

	/** @param Closure(non-empty-list<Predicate>):PredicateAggregate $aggregate */
	#[DataProvider('aggregators')]
	public function test_fieldShape_shouldProduceExpectedPredicate(Closure $aggregate): void {
		$expectEqual = 1;
		$expectGt = 2;
		$shape = [ 'a' => $expectEqual, 'b' => fn(ValuePath $path) => new Predicate\GreaterThan($path, $expectGt) ];
		$path = new ValuePath([ 'foo' ]);

		$result = Q::fieldShape($shape, $aggregate)($path);

		$this->assertSame(\count($shape), \count($result->inputs));
		[ $pred0, $pred1 ] = $result->inputs;
		$this->assertInstanceOf(Predicate\Equal::class, $pred0);
		$this->assertInstanceOf(ValuePath::class, $pred0->lhs);
		$this->assertSame([ 'foo' ], $pred0->lhs->fieldPath);
		$this->assertSame([ 'a' ], $pred0->lhs->innerPath);
		$this->assertSame($expectEqual, $pred0->rhs);
		$this->assertInstanceOf(Predicate\GreaterThan::class, $pred1);
		$this->assertInstanceOf(ValuePath::class, $pred1->lhs);
		$this->assertSame([ 'foo' ], $pred1->lhs->fieldPath);
		$this->assertSame([ 'b' ], $pred1->lhs->innerPath);
		$this->assertSame($expectGt, $pred1->rhs);
	}

	public static function logicalMethods(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ 'and' ];
		yield [ 'or' ];
	}

	/** @param 'and'|'or' $method */
	#[DataProvider('logicalMethods')]
	public function test_logicalMethod_shouldProduceExpectedCompositePredicate(string $method): void {
		$path = [ 'foo' ];
		$expectGt = 0;
		$expectNeq = -1;
		$inputs = [ Q::gt($expectGt), Q::neq($expectNeq) ];

		$result = [ Q::class, $method ]($inputs)(new ValuePath($path));

		$this->assertSame(\count($inputs), \count($result->inputs));
		$this->assertInstanceOf(Predicate\GreaterThan::class, $result->inputs[0]);
		$this->assertInstanceOf(ValuePath::class, $result->inputs[0]->lhs);
		$this->assertSame($path, $result->inputs[0]->lhs->fieldPath);
		$this->assertSame($expectGt, $result->inputs[0]->rhs);
		$this->assertInstanceOf(Predicate\NotEqual::class, $result->inputs[1]);
		$this->assertInstanceOf(ValuePath::class, $result->inputs[1]->lhs);
		$this->assertSame($path, $result->inputs[1]->lhs->fieldPath);
		$this->assertSame($expectNeq, $result->inputs[1]->rhs);
	}

	public function test_eq_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = true;
		$sut = Q::eq($rhsValue);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_neq_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = 5;
		$sut = Q::neq($rhsValue);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_gt_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = 1;
		$sut = Q::gt($rhsValue);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_gte_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = -3;
		$sut = Q::gte($rhsValue);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_lt_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = 99;
		$sut = Q::lt($rhsValue);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_lte_shouldProduceValidPredicate(): void {
		$field = 'test';
		$rhsValue = 42;
		$sut = Q::lte($rhsValue);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($rhsValue, $result->rhs);
	}

	public function test_matchAll_shouldProduceValidPredicate(): void {
		$expectedResult = [ 1, 2, 3 ];
		$field = 'test';
		$sut = Q::matchAll($expectedResult);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertSame([ $field ], $result->valueAt->fieldPath);
		$this->assertSame($expectedResult, $result->values);
	}

	public function test_matchSome_shouldProduceValidPredicate(): void {
		$expectedResult = [ 'a', 'b', 'c' ];
		$field = 'test';
		$sut = Q::matchSome($expectedResult);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertSame([ $field ], $result->valueAt->fieldPath);
		$this->assertSame($expectedResult, $result->values);
	}

	public function test_matchNone_shouldProduceValidPredicate(): void {
		$expectedResult = [ 0, true, null ];
		$field = 'test';
		$sut = Q::matchNone($expectedResult);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertSame([ $field ], $result->valueAt->fieldPath);
		$this->assertSame($expectedResult, $result->values);
	}

	public function test_regex_shouldProduceValidPredicate(): void {
		$expectedResult = '^pen';
		$field = 'test';
		$sut = Q::regex($expectedResult);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertSame([ $field ], $result->valueAt->fieldPath);
		$this->assertSame($expectedResult, $result->regex);
	}

	public function test_isEmpty_shouldProduceValidPredicate(): void {
		$sut = Q::isEmpty();
		$field = 'test';
		$checkNotExists = false;

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(Predicate\Or_::class, $result);
		foreach ($result->inputs as $predicate) {
			if ($predicate instanceof Predicate\NotExists) {
				$checkNotExists = true;
				$this->assertSame([ $field ], $predicate->path->fieldPath);
			} else if ($predicate instanceof Predicate\MatchSome) {
				$this->assertSame([ $field ], $predicate->valueAt->fieldPath);
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

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(Predicate\And_::class, $result);
		foreach ($result->inputs as $predicate) {
			if ($predicate instanceof Predicate\Exists) {
				$checkExists = true;
				$this->assertSame([ $field ], $predicate->path->fieldPath);
			} else if ($predicate instanceof Predicate\MatchNone) {
				$this->assertSame([ $field ], $predicate->valueAt->fieldPath);
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

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($expectedResult, $result->rhs);
	}

	public function test_onOrBefore_shouldProduceValidPredicate(): void {
		$expectedResult = new DateTime;
		$field = 'foo';
		$sut = Q::onOrBefore($expectedResult);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($expectedResult, $result->rhs);
	}

	public function test_after_shouldProduceValidPredicate(): void {
		$expectedResult = new DateTime;
		$field = 'foo';
		$sut = Q::after($expectedResult);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($expectedResult, $result->rhs);
	}

	public function test_onOrAfter_shouldProduceValidPredicate(): void {
		$expectedResult = new DateTime;
		$field = 'foo';
		$sut = Q::onOrAfter($expectedResult);

		$result = $sut(new ValuePath([ $field ]));

		$this->assertInstanceOf(ValuePath::class, $result->lhs);
		$this->assertSame([ $field ], $result->lhs->fieldPath);
		$this->assertSame($expectedResult, $result->rhs);
	}

	public function test_valueAt_shouldReturnExpectedResult(): void {
		$fieldPath = [ 'reference', 'field' ];
		$innerPath = [ 'path', 'in', '0', 'json' ];

		$result = Q::valueAt($fieldPath, $innerPath);

		$this->assertSame($fieldPath, $result->fieldPath);
		$this->assertSame($innerPath, $result->innerPath);
	}

	/** @param non-empty-list<Predicate> $inputs */
	private static function newAnd(array $inputs): Predicate\And_ {
		return new Predicate\And_($inputs);
	}

	/** @param non-empty-list<Predicate> $inputs */
	private static function newOr(array $inputs): Predicate\Or_ {
		return new Predicate\Or_($inputs);
	}

}
