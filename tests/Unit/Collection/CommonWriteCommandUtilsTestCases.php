<?php

namespace Slendium\OcdTests\Unit\Collection;

use Slendium\Ocd\Collection\WriteAcknowledgment;

/**
 * @internal
 * @phpstan-require-extends WriteCommandTestCase
 * @author C. Fahner
 * @copyright Slendium 2026
 */
trait CommonWriteCommandUtilsTestCases {

	public function test_execute_shouldTriggerExecute(): void {
		$executed = false;
		$command = new Mocks\MockWriteCommand(onExecute: function() use (&$executed) {
			$executed = true;
		});

		[ $this->getWriteCommandClass(), 'execute' ]($command);

		$this->assertTrue($executed);
	}

	public function test_setAcknowledgment_shouldApplyGivenValue(): void {
		// Arrange
		$expectedResult = WriteAcknowledgment::MajorityReplicated;
		$command = new Mocks\MockWriteCommand;

		// Assert
		$this->assertNull($command->writeOptions->acknowledgment);

		// Act
		[ $this->getWriteCommandClass(), 'setAcknowledgment' ]($command, $expectedResult);
		$result = $command->writeOptions->acknowledgment;

		// Assert
		$this->assertSame($expectedResult, $result);
	}

	public function test_fireAndForget_shouldExecuteWithoutAcknowledgment(): void {
		$executed = false;
		$command = new Mocks\MockWriteCommand(onExecute: static function() use (&$executed) {
			$executed = true;
		});

		[ $this->getWriteCommandClass(), 'fireAndForget' ]($command);
		$result = $command->writeOptions->acknowledgment;

		$this->assertTrue($executed);
		$this->assertSame(WriteAcknowledgment::None, $result);
	}

}
