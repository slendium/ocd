# The object-collection-documentor

Database- and framework agnostic database abstraction layer / ORM for PHP.

* Supports MongoDB and SQL-based databases, can be extended further
* Supports custom / derived types as long as they go back to the same primitives
* Entities are based on plain PHP classes, adding `#[Attribute]`'s only where more specificity is needed
* Does not force the active record pattern, inheritance, or a rich domain model (nor exclude them)
* No LLM-generated code
* No dependencies

## Installation

Requires **PHP >= 8.5**.
Run `composer require slendium/ocd` to add it to your project.
However, most likely you are looking for a database-specific implementation of the library:

* [MariaDB](https://git.frisiapp.com/slendium/ocd-mariadb)
* [SQLite](https://git.frisiapp.com/slendium/ocd-sqlite)
* [MongoDB](https://git.frisiapp.com/slendium/ocd-mongodb)
* [In-memory](https://git.frisiapp.com/slendium/ocd-memory) (for testing)

For implementors there is also the [OCD conformance](https://git.frisiapp.com/slendium/ocd-conformance-tests) package,
which contains implementation guides and PHPUnit tests.

## Examples

### Data definition

#### Basic entity

A basic entity only requires a plain PHP class declaration.

```php
final readonly class Product implements Entity {

	public function __construct(

		#[Override]
		public Entity\UniqueIdentifier $id,

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

Data can be queried using a set of generalized expressions.
You can manually construct them, use a predefined builder utility or create your own builder.
An example using the built-in "document shape" query builder:

```php
use Slendium\Ocd\Predicate\DocumentShape as Q;

$filter = Q::shape([
	'year' => 2026, // match a literal int
	'views' => Q::gte(1000),
	'title' => Q::regex('^'),
	'tags' => Q::containsSome([ 'news', 'updates' ])
]);

$cursor = $collection->openCursor()
	|> Cursor::filter(?, $filter)
	|> Cursor::skip(?, $page * PAGE_SIZE)
	|> Cursor::limit(?, PAGE_SIZE);

foreach ($cursor as $doc) { } // do something with each document
```

### Manipulating data

#### Inserting data

Data can be inserted by passing "documents" to an insert command.
A document is any object that is `ArrayAccess&Countable&Traversable` with non-empty strings for keys.
See the documentation of the `Collection::startInsert()` function to learn more about what types of
values can be contained in inserted documents.
An example:

```php
$document = new MutableDocument([
	'name' => 'foo',
	'createdAt' => new DateTime,
	'location' => [ $latitude, $longitude ],
	'owner' => $userEntity,
]);

$collection->startInsert([ $document ])
	|> InsertCommand::fireAndForget(?);
```

#### Updating data

Data can be updated by providing a query and a list of update statements.
Analogous to the data querying example, update statement lists can be constructed manually or through
builder utilities.
An example:

```php
use Slendium\Ocd\Predicate\DocumentShape as Q;
use Slendium\Ocd\Update\DocumentUpdate as U;

$filter = Q::shape([ 'id' => $updateId ]);

$updates = U::create([
	'name' => $newName,
	'modificationCount' => U::add(1),
	'auditLog' => U::append("At $modifiedAt, user {$user->name} changed name to `$newName`"),
	'details' => U::path([ 'neverModifiedFlag', U::unset() ])
]);

$collection->startUpdate($filter, $updates)
	|> UpdateCommand::execute(?);
```

#### Deleting data

Data can be deleted by creating a delete command and executing it.
An example:

```php
$filter = Q::shape([ 'id' => $id ]);

$collection->startDelete($filter)
	|> DeleteCommand::enforceLimit(?, 1)
	|> DeleteCommand::execute(?);
```

## Roadmap

1. **[Done]** Describing the schema
1. **[Done]** Data manipulation (create, update, delete)
1. **[Done]** Reading queried data from a cursor
1. Relationships and indices
1. Entity reassembly
1. Geospatial data
1. Data aggregation
1. Transactions

### Out of scope

Tracking entity changes, persisting entities, and the active record pattern.

