<?php

namespace Slendium\OcdTests\Unit\Collection;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @template T
 * @author C. Fahner
 * @copyright Slendium 2026
 */
abstract class WriteCommandTestCase extends TestCase {

	/** @return class-string<T> */
	protected abstract function getWriteCommandClass(): string;

}
