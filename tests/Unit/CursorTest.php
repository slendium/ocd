<?php

namespace Slendium\OcdTests\Unit;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Cursor;
use Slendium\Ocd\Predicate\DocumentShape as Q;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class CursorTest extends TestCase {

	public function test_filter_shouldApplyPredicate(): void {
		$expectedResult = Q::shape([ 'id' => '22' ]);
		$filterable = new CursorTest\FakeFilterable;

		$result = Cursor::filter($filterable, $expectedResult)->filter;

		$this->assertSame($expectedResult, $result);
	}

	public function test_skip_shouldApplySkip(): void {
		$expectedResult = 20;
		$scrollable = new CursorTest\FakeScrollable;

		$result = Cursor::skip($scrollable, $expectedResult)->skip;

		$this->assertSame($expectedResult, $result);
	}

	public function test_limit_shouldApplyLimit(): void {
		$expectedResult = 50;
		$scrollable = new CursorTest\FakeScrollable;

		$result = Cursor::limit($scrollable, $expectedResult)->limit;

		$this->assertSame($expectedResult, $result);
	}

	public function test_scroll_shouldApplyBothSkipAndLimit(): void {
		$skip = 150;
		$limit = 50;
		$scrollable = new CursorTest\FakeScrollable;

		Cursor::scroll($scrollable, $skip, $limit);

		$this->assertSame($skip, $scrollable->skip);
		$this->assertSame($limit, $scrollable->limit);
	}

}
