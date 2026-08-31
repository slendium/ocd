<?php

namespace Slendium\OcdTests\Unit\Collection;

use Override;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Collection\DeleteCommand;

/**
 * @internal
 * @extends WriteCommandTestCase<DeleteCommand>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class DeleteCommandTest extends WriteCommandTestCase {

	use CommonWriteCommandUtilsTestCases;

	use CommonUpdateAndDeleteCommandUtilsTestCases;

	#[Override]
	protected function getWriteCommandClass(): string {
		return DeleteCommand::class;
	}

}
