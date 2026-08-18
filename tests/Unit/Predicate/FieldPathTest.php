<?php

namespace Slendium\OcdTests\Unit\Predicate;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Predicate\FieldPath;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class FieldPathTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$path = [ 'test' ];

		$result = new FieldPath(path: $path);

		$this->assertSame($path, $result->path);
	}

}
