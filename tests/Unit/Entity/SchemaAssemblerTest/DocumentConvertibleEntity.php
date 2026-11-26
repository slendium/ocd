<?php

namespace Slendium\OcdTests\Unit\Entity\SchemaAssemblerTest;

use ArrayAccess;
use Countable;
use Override;
use Traversable;

use Slendium\Ocd\Entity;
use Slendium\Ocd\Schema;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class DocumentConvertibleEntity implements Entity, Entity\FromDocument {

	/** @param ArrayAccess<non-empty-string,mixed>&Countable&Traversable<non-empty-string,mixed> $doc */
	#[Override]
	public static function fromDocument(ArrayAccess&Countable&Traversable $doc): self {
		return new self(
			id: $doc['id'] ?? '', // @phpstan-ignore argument.type
			name: $doc['name'] ?? '', // @phpstan-ignore argument.type
			staticallyConstructed: true,
		);
	}

	private function __construct(

		#[Override]
		public string $id,

		public string $name,

		#[Schema\Exclude]
		public bool $staticallyConstructed = false,

	) { }

}
