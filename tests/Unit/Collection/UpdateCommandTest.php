<?php

namespace Slendium\OcdTests\Unit\Collection;

use Override;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Collection\UpdateCommand;

/**
 * @internal
 * @extends WriteCommandTestCase<UpdateCommand>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class UpdateCommandTest extends WriteCommandTestCase {

	use CommonWriteCommandUtilsTestCases;

	use CommonUpdateAndDeleteCommandUtilsTestCases;

	#[Override]
	protected function getWriteCommandClass(): string {
		return UpdateCommand::class;
	}

}
