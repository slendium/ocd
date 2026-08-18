<?php

namespace Slendium\OcdTests\Unit\Predicate;

use ReflectionClass;
use ReflectionNamedType;

use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Predicate;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class VisitorTest extends TestCase {

	public function test_interface_shouldCoverAllExprs(): void {
		$exprDir = \dirname(new ReflectionClass(Predicate::class)->getFileName()).'/Predicate/Expr'; // @phpstan-ignore argument.type (getFileName wont be false)
		$variants = [ ];
		foreach (\glob("$exprDir/*.php") as $path) { // @phpstan-ignore foreach.nonIterable (glob wont be false)
			$variants['Slendium\\Ocd\\Predicate\\Expr\\'.\basename($path, '.php')] = false;
		}

		$this->assertNotEmpty($variants);

		foreach (new ReflectionClass(Predicate\Visitor::class)->getMethods() as $method) {
			foreach ($method->getParameters() as $i => $parameter) {
				$type = $parameter->getType();
				$this->assertInstanceOf(ReflectionNamedType::class, $type);
				$this->assertTrue(isset($variants[$type->getName()]), "Visitor interface contains method for non-existant expression $type");
				$variants[$type->getName()] = true;
				break;
			}
		}

		foreach ($variants as $variant => $found) {
			$this->assertTrue($found, "Visitor interface is missing method to visit $variant");
		}
	}

}
