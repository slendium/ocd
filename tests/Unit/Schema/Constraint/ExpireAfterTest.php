<?php

namespace Slendium\OcdTests\Unit\Schema\Constraint;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Constraint\ExpireAfter;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class ExpireAfterTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$field = 'foo';

		$sut = new ExpireAfter(field: $field);

		$this->assertSame($field, $sut->field);
	}

}
