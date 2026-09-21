<?php

namespace Slendium\OcdTests\Unit\Schema\Type;

use Slendium\Ocd\Schema\Type\SerializeException;
use Slendium\OcdTests\Common\TestCase\ExceptionTestCase;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class SerializeExceptionTest extends ExceptionTestCase {

	public function test___construct_shouldSupportDefaultArguments(): void {
		$this->assertDefaultConstructorAccessible(SerializeException::class);
	}

}
