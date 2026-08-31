<?php

namespace Slendium\OcdTests\Unit\Collection;

use Override;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Collection\InsertCommand;

/**
 * @internal
 * @extends WriteCommandTestCase<InsertCommand>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class InsertCommandTest extends WriteCommandTestCase {

	use CommonWriteCommandUtilsTestCases;

	#[Override]
	protected function getWriteCommandClass(): string {
		return InsertCommand::class;
	}

}
