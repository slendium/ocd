<?php

namespace Slendium\OcdBench\Php;

use ReflectionMethod;
use ReflectionParameter;

use PhpBench\Attributes as Bench;

/**
 * Benchmark on the fastest method to get the first instance of an attribute.
 *
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class AttributeGetBench {

	private const REVS = 1_000_000;

	private const ITERATIONS = 3;

	private ReflectionParameter $singleAttr;

	private ReflectionParameter $multiAttr;

	public function __construct() {
		$this->singleAttr = new ReflectionMethod(self::class, 'methodWithMarkerOnly')->getParameters()[0];
		$this->multiAttr = new ReflectionMethod(self::class, 'methodWithMarkerAndOthers')->getParameters()[0];
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIterateAndReturn_single(): ?Marker {
		foreach ($this->singleAttr->getAttributes(Marker::class) as $attr) {
			return $attr->newInstance();
		}
		return null;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIterateAndReturn_multi(): ?Marker {
		foreach ($this->multiAttr->getAttributes(Marker::class) as $attr) {
			return $attr->newInstance();
		}
		return null;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIsset_single(): ?Marker {
		$attrs = $this->singleAttr->getAttributes(Marker::class);
		return isset($attrs[0])
			? $attrs[0]->newInstance()
			: null;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIsset_multi(): ?Marker {
		$attrs = $this->multiAttr->getAttributes(Marker::class);
		return isset($attrs[0])
			? $attrs[0]->newInstance()
			: null;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIssetNoAssign_single(): ?Marker {
		return isset($this->singleAttr->getAttributes(Marker::class)[0])
			? $this->singleAttr->getAttributes(Marker::class)[0]->newInstance()
			: null;
	}

	#[Bench\Revs(self::REVS), Bench\Iterations(self::ITERATIONS)]
	public function benchIssetNoAssign_multi(): ?Marker {
		return isset($this->singleAttr->getAttributes(Marker::class)[0])
			? $this->singleAttr->getAttributes(Marker::class)[0]->newInstance()
			: null;
	}

	public function methodWithMarkerOnly(#[Marker] int $marked): void { }

	public function methodWithMarkerAndOthers(#[Attr1, Attr2, Marker] int $marked): void { }

}
