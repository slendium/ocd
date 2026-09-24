<?php

namespace Slendium\OcdTests\Unit\Schema;

use Slendium\Ocd\Schema\DefinitionException;
use Slendium\OcdTests\Common\TestCase\ExceptionTestCase;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DefinitionExceptionTest extends ExceptionTestCase {

	public function test___construct_shouldSupportDefaultArguments(): void {
		$this->assertDefaultConstructorAccessible(DefinitionException::class);
	}

}
