<?php

namespace Slendium\OcdBench\Php;

use ReflectionMethod;
use ReflectionParameter;

use PhpBench\Attributes as Bench;

/**
 * Benchmark on the fastest method to check an attribute exists.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class AttributeCheckBench {

	private const REVS = 1_000_000;

	private const ITERATIONS = 3;

	private ReflectionParameter $singleAttr;

	private ReflectionParameter $multiAttr;

	public function __construct() {
		$this->singleAttr = new ReflectionMethod(self::class, 'methodWithMarkerOnly')->getParameters()[0];
		$this->multiAttr = new ReflectionMethod(self::class, 'methodWithMarkerAndOthers')->getParameters()[0];
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIterateAndReturn_single(): bool {
		foreach ($this->singleAttr->getAttributes(Marker::class) as $_) {
			return true;
		}
		return false;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIterateAndReturn_multi(): bool {
		foreach ($this->multiAttr->getAttributes(Marker::class) as $_) {
			return true;
		}
		return false;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchCountGtZero_single(): bool {
		return \count($this->singleAttr->getAttributes(Marker::class)) > 0;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchCountGtZero_multi(): bool {
		return \count($this->multiAttr->getAttributes(Marker::class)) > 0;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIsset_single(): bool {
		return isset($this->singleAttr->getAttributes(Marker::class)[0]);
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIsset_multi(): bool {
		return isset($this->multiAttr->getAttributes(Marker::class)[0]);
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchNotEmpty_single(): bool {
		return !empty($this->singleAttr->getAttributes(Marker::class));
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchNotEmpty_multi(): bool {
		return !empty($this->multiAttr->getAttributes(Marker::class));
	}

	public function methodWithMarkerOnly(#[Marker] int $marked): void { }

	public function methodWithMarkerAndOthers(#[Attr1, Attr2, Marker] int $marked): void { }

}
