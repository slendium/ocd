<?php

namespace Slendium\Ocd\Collection;

use InvalidArgumentException;

/**
 * Common functions for update and delete commands.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
trait CommonUpdateAndDeleteCommandUtils {

	/**
	 * Enforces a limit on the amount of documents affected, throwing if the command implementation
	 * does not support limits.
	 * @since 1.0
	 * @see LimitableCommand
	 * @template T of WriteCommand
	 * @param T $command
	 * @param int<1,max> $limit
	 * @return T
	 */
	public static function enforceLimit(WriteCommand $command, int $limit): WriteCommand {
		if (!($command instanceof LimitableCommand)) {
			throw new InvalidArgumentException('Expected given command to be limitable');
		}

		$command->limit = $limit; // @phpstan-ignore assign.propertyType (bug? limit is not a plain int??)
		return $command;
	}

	/**
	 * Suggests a limit for the amount of documents affected. Does nothing if the command implementation
	 * does not support limits.
	 * @since 1.0
	 * @see LimitableCommand
	 * @template T of WriteCommand
	 * @param T $command
	 * @param int<1,max> $limit
	 * @return T
	 */
	public static function suggestLimit(WriteCommand $command, int $limit): WriteCommand {
		if ($command instanceof LimitableCommand) {
			$command->limit = $limit; // @phpstan-ignore assign.propertyType (bug? limit is not a plain int??)
		}

		return $command;
	}

	private function __construct() { }

}
