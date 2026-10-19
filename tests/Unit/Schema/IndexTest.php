<?php

namespace Slendium\OcdTests\Unit\Schema;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Index;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class IndexTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$fields = [ 'foo' ];

		$sut = new Index(fields: $fields);

		$this->assertSame($fields, $sut->fields);
	}

}
