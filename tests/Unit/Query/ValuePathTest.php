<?php

namespace Slendium\OcdTests\Unit\Query;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Query\ValuePath;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class ValuePathTest extends TestCase {

	public function test___construct_shouldNotRequireInnerPath(): void {
		$fieldPath = [ 'foo', 'bar' ];

		$result = new ValuePath(fieldPath: $fieldPath);

		$this->assertSame($fieldPath, $result->fieldPath);
	}

	public function test__construct_shouldNotThrow(): void {
		$fieldPath = [ 'foo', 'bar' ];
		$innerPath = [ 'baz' ];

		$result = new ValuePath(fieldPath: $fieldPath, innerPath: $innerPath);

		$this->assertSame($fieldPath, $result->fieldPath);
		$this->assertSame($innerPath, $result->innerPath);
	}

}
