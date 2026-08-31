<?php

namespace Slendium\Ocd\Collection;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
trait CommonWriteCommandUtils {

	/**
	 * Sets the write acknowledgment to "none" and executes the command immediately.
	 *
	 * @since 1.0
	 * @see WriteAcknowledgment::None
	 */
	public static function fireAndForget(WriteCommand $command): void {
		self::setAcknowledgment($command, WriteAcknowledgment::None)
			->execute();
	}

	/**
	 * Sets the write acknowledgment on the write options of the given command and returns the command.
	 * @since 1.0
	 * @template T of WriteCommand
	 * @param T $command
	 * @return T
	 */
	public static function setAcknowledgment(WriteCommand $command, WriteAcknowledgment $acknowledgment): WriteCommand {
		$command->writeOptions->acknowledgment = $acknowledgment;
		return $command;
	}

	/** @since 1.0 */
	public static function execute(WriteCommand $command): void {
		$command->execute();
	}

}
