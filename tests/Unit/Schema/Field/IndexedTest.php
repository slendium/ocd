<?php

namespace Slendium\OcdTests\Unit\Schema\Field;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Field\Indexed;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class IndexedTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		// Assert
		$this->expectNotToPerformAssertions();

		// Act
		$_ = new Indexed;
	}

}
