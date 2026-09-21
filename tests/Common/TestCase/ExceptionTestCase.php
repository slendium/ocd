<?php

namespace Slendium\OcdTests\Common\TestCase;

use Exception;

use PHPUnit\Framework\TestCase;

/**
 * Contains assertions for exceptions.
 *
 * Creating custom constructors for custom exception types is allowed. However, when the default
 * constructor is used initially and a custom constructor is added later, this is a breaking change
 * that should be detected through a unit test.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
abstract class ExceptionTestCase extends TestCase {

	/** @param class-string<Exception> $exceptionClass */
	protected final function assertDefaultConstructorAccessible(string $exceptionClass): void {
		$_ = new $exceptionClass; // ensure all parameters are optional

		$expectedMessage = '5db0f56c-0f24-4733-aab6-b0001f84327c';
		$expectedCode = 4_947_385;
		$expectedPrevious = new Exception('!');

		$resultPositional = new $exceptionClass($expectedMessage, $expectedCode, $expectedPrevious);
		$this->assertSame($expectedMessage, $resultPositional->getMessage());
		$this->assertSame($expectedCode, $resultPositional->getCode());
		$this->assertSame($expectedPrevious, $resultPositional->getPrevious());

		$resultNamed = new $exceptionClass(
			message: $expectedMessage,
			code: $expectedCode,
			previous: $expectedPrevious,
		);
		$this->assertSame($expectedMessage, $resultNamed->getMessage());
		$this->assertSame($expectedCode, $resultNamed->getCode());
		$this->assertSame($expectedPrevious, $resultNamed->getPrevious());
	}

}
