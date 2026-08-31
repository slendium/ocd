<?php

namespace Slendium\OcdTests\Unit\Collection\Mocks;

use Closure;
use Override;

use Slendium\Ocd\Collection\WriteCommand;
use Slendium\Ocd\Collection\WriteOptions;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class MockWriteCommand implements WriteCommand {

	#[Override]
	public WriteOptions $writeOptions;

	public function __construct(

		/** @var Closure():void */
		private Closure $onExecute = static function() { },

	) {
		$this->writeOptions = new WriteOptions;
	}

	public function execute(): void {
		($this->onExecute)();
	}

}
