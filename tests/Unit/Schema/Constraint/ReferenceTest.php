<?php

namespace Slendium\OcdTests\Unit\Schema\Constraint;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Ocd\Schema\Constraint\ConstraintAction;
use Slendium\Ocd\Schema\Constraint\Reference;
use Slendium\Ocd\Schema\DefinitionException;
use Slendium\OcdTests\Common\Entities as TestEntities;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class ReferenceTest extends TestCase {

	public function test___construct_shouldNotThrow_whenOptionalArgsOmitted(): void {
		$fieldMapping = [ 'foo' => 'id' ];
		$targetClass = TestEntities\EntityWithId::class;

		$sut = new Reference(targetClass: $targetClass, fieldMapping: $fieldMapping);

		$this->assertSame($targetClass, $sut->targetClass);
		$this->assertSame($fieldMapping, \array_map(fn($f) => $f->name, $sut->fieldMapping));
		$this->assertSame(ConstraintAction::Cascade, $sut->onUpdate);
		$this->assertSame(ConstraintAction::Restrict, $sut->onDelete);
	}

	public function test___construct_shouldNotThrow_whenAllArgumentsGiven(): void {
		$fieldMapping = [ 'foo' => 'id' ];
		$targetClass = TestEntities\EntityWithId::class;
		$action = ConstraintAction::SetNull;

		$sut = new Reference(
			targetClass: $targetClass,
			fieldMapping: $fieldMapping,
			onUpdate: $action,
			onDelete: $action
		);

		$this->assertSame($targetClass, $sut->targetClass);
		$this->assertSame($fieldMapping, \array_map(fn($f) => $f->name, $sut->fieldMapping));
		$this->assertSame($action, $sut->onUpdate);
		$this->assertSame($action, $sut->onDelete);
	}

	public static function definitionExceptionCases(): iterable { // @phpstan-ignore missingType.iterableValue
		// if the field being referenced has an invalid type, the reference itself also becomes invalid
		foreach (TestEntities::getClassesWithInvalidFieldType() as $i => $class) {
			yield "bad-reference-$i" => [ $class, [ 'foo' => 'field' ] ];
		}

		// here the referenced object is valid, but the field mapping is not
		yield 'too-many' => [ TestEntities\EntityWithId::class, [ 'foo' => 'id', 'bar' => 'no_exists' ] ];
		yield 'empty' => [ TestEntities\ObjectWithoutFields::class, [ 'foo' => 'id' ] ];
		yield 'recursive' => [ TestEntities\ObjectWithReferentialId::class, [ 'foo' => 'id' ] ];
	}

	/**
	 * @param class-string $class
	 * @param non-empty-array<non-empty-string, non-empty-string> $mapping
	 */
	#[DataProvider('definitionExceptionCases')]
	public function test___construct_shouldThrow(string $class, array $mapping): void {
		// Assert
		$this->expectException(DefinitionException::class);

		// Act
		$_ = new Reference($class, $mapping);
	}

}
