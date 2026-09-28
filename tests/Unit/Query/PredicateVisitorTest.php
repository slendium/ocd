<?php

namespace Slendium\OcdTests\Unit\Query;

use ReflectionClass;
use ReflectionNamedType;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Query\Predicate;
use Slendium\Ocd\Query\PredicateVisitor;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class PredicateVisitorTest extends TestCase {

	public function test_interface_shouldCoverAllPredicates(): void {
		$exprDir = \dirname(new ReflectionClass(Predicate::class)->getFileName()).'/Predicate'; // @phpstan-ignore argument.type (getFileName wont be false)
		$variants = [ ];
		foreach (\glob("$exprDir/*.php") as $path) { // @phpstan-ignore foreach.nonIterable (glob wont be false)
			$variants['Slendium\\Ocd\\Query\\Predicate\\'.\basename($path, '.php')] = false;
		}

		$this->assertNotEmpty($variants);

		foreach (new ReflectionClass(PredicateVisitor::class)->getMethods() as $method) {
			foreach ($method->getParameters() as $i => $parameter) {
				$type = $parameter->getType();
				$this->assertInstanceOf(ReflectionNamedType::class, $type);
				$this->assertTrue(isset($variants[$type->getName()]), "PredicateVisitor interface contains method for non-existant expression $type");
				$variants[$type->getName()] = true;
				break;
			}
		}

		foreach ($variants as $variant => $found) {
			$this->assertTrue($found, "PredicateVisitor interface is missing method to visit $variant");
		}
	}

}
