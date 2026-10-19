<?php

namespace Slendium\OcdTests\Unit\Schema\Constraint;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Constraint\Unique;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UniqueTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$fields = [ 'foo' ];

		$sut = new Unique(fields: $fields);

		$this->assertSame($fields, $sut->fields);
	}

}
