<?php

namespace Slendium\OcdTests\Unit\Collection;

use InvalidArgumentException;

/**
 * @internal
 * @phpstan-require-extends WriteCommandTestCase
 * @author C. Fahner
 * @copyright Slendium 2026
 */
trait CommonUpdateAndDeleteCommandUtilsTestCases {

	public function test_enforceLimit_shouldThrow_whenCalledWithNonLimitableCommand(): void {
		// Arrange
		$command = new Mocks\MockWriteCommand;

		// Assert
		$this->expectException(InvalidArgumentException::class);

		// Act
		[ $this->getWriteCommandClass(), 'enforceLimit' ]($command, 10);
	}

	public function test_enforceLimit_shouldNotThrow_whenCalledWithLimitableCommand(): void {
		$expectedResult = 1;
		$command = new Mocks\MockLimitableWriteCommand;

		[ $this->getWriteCommandClass(), 'enforceLimit' ]($command, $expectedResult);
		$result = $command->limit;

		$this->assertSame($expectedResult, $result);
	}

	public function test_suggestLimit_shouldNotThrow_whenCalledWithNonLimitableCommand(): void {
		// Arrange
		$command = new Mocks\MockWriteCommand;

		// Assert
		$this->expectNotToPerformAssertions();

		// Act
		[ $this->getWriteCommandClass(), 'suggestLimit' ]($command, 1);
	}

	public function test_suggestLimit_shouldApplyLimit_whenCalledWithLimitableCommand(): void {
		$expectedResult = 1;
		$command = new Mocks\MockLimitableWriteCommand;

		[ $this->getWriteCommandClass(), 'suggestLimit' ]($command, $expectedResult);
		$result = $command->limit;

		$this->assertSame($expectedResult, $result);
	}

}
