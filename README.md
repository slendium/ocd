# The object-collection-documentor

Database- and framework agnostic database abstraction layer / ORM for PHP.

* Supports MongoDB and SQL-based databases, can be extended further
* Supports custom / derived types as long as they go back to the same primitives
* Entities are based on plain PHP classes, adding `#[Attribute]`'s only where more specificity is needed
* Does not force the active record pattern, inheritance, or a rich domain model (nor exclude them)
* Developed without LLM's

## Installation

Requires **PHP >= 8.5**.
Run `composer require slendium/ocd` to add it to your project.
However, most likely you are looking for a database-specific implementation of the library:

* [MariaDB](https://git.frisiapp.com/slendium/ocd-mariadb)
* [SQLite](https://git.frisiapp.com/slendium/ocd-sqlite)
* [MongoDB](https://git.frisiapp.com/slendium/ocd-mongodb)
* [In-memory](https://git.frisiapp.com/slendium/ocd-memory) (for testing)

For implementors there is also the [OCD conformance](https://git.frisiapp.com/slendium/ocd-conformance) package,
which contains implementation guides and PHPUnit test suites.

## Examples

### Data definition

#### Basic entity

A basic entity only requires a plain PHP class declaration.

```php
final readonly class Product implements Entity, Entity\Identifiable {

	public function __construct(

		#[Override]
		public Entity\Id $id,

		public string $name,

		public float $price,

		public bool $visible = false,

		public int $stock = 0,

	) { }

}
```

#### Relationships and indices

TODO

### Querying

TODO

### Manipulating data

TODO

## Roadmap

1. **[Done]** Describing the schema
1. Relationships and indices
1. Data manipulation
	1. Create commands
	1. Update commands
	1. Delete commands
1. Data querying
	1. Reading from a cursor
	1. Entity reassembly
1. Migrating/upgrading data
1. Data aggregation (GROUP BY and friends)
1. Transactions

### Out of scope

Tracking entity changes, persisting entities, and the active record pattern.

