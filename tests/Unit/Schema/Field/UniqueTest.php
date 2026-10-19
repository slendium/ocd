<?php

namespace Slendium\OcdTests\Unit\Schema\Field;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Field\Unique;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UniqueTest extends TestCase {

	public function test___construct_shouldNotThrow(): void {
		// Assert
		$this->expectNotToPerformAssertions();

		// Act
		$_ = new Unique;
	}

}
