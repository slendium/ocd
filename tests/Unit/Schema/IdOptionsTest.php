<?php

namespace Slendium\OcdTests\Unit\Schema;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\IdGenerator;
use Slendium\Ocd\Schema\IdOptions;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class IdOptionsTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		$generator = IdGenerator::UniqueIdentifier;

		$sut = new IdOptions($generator);

		$this->assertSame($generator, $sut->generator);
	}

}
