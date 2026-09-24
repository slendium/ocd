<?php

namespace Slendium\OcdTests\Unit\Schema\Types;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Types\DateTime;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DateTimeTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		// Assert
		$this->expectNotToPerformAssertions();

		// Act
		$_ = new DateTime;
	}

}
