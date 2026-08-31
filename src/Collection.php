<?php

namespace Slendium\Ocd;

use ArrayAccess;
use Countable;
use Traversable;

use Slendium\Ocd\Collection\WriteCommand;
use Slendium\Ocd\Cursor\Filterable;
use Slendium\Ocd\Cursor\Scrollable;
use Slendium\Ocd\Predicate;
use Slendium\Ocd\Update;

/**
 * A repository of documents that can be queried and manipulated.
 *
 * This is a data access object equivalent to one table in relational databases.
 * It provides the low level operations on top of which higher level functionality should be built,
 * such as entity cursors and (de)serialization according to a schema.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Collection {

	/**
	 * Opens a new cursor backed by this collection.
	 * @since 1.0
	 * @see Cursor
	 * @return Filterable&Scrollable&Traversable<ArrayAccess<non-empty-string,mixed>&Countable&Traversable<non-empty-string,mixed>>
	 */
	public function openCursor(): Filterable&Scrollable&Traversable;

	/**
	 * Creates a new command that allows inserting one or more documents into the collection.
	 *
	 * Only values that map to a {@see Schema\StorageClass} can be inserted safely.
	 * The behavior of inserting any other type of value is implementation dependent.
	 *
	 * @since 1.0
	 * @see Collection\InsertCommand
	 * @see Document\MutableDocument
	 * @param non-empty-list<ArrayAccess<non-empty-string,mixed>&Countable&Traversable<non-empty-string,mixed>> $documents
	 */
	public function startInsert(array $documents): WriteCommand;

	/**
	 * Creates a new command that allows updating zero or more documents in a collection.
	 *
	 * Some implementations may support {@see Collection\LimitableCommand} on updates.
	 * Perform a type check on the returned {@see Command} object before applying a limit.
	 * Not all implementations may allow limits other than `0` (unlimited) or `1`.
	 *
	 * @since 1.0
	 * @see Collection\UpdateCommand
	 * @param non-empty-list<Update> $updates
	 */
	public function startUpdate(Predicate $filter, array $updates): WriteCommand;

	/**
	 * Creates a new command that allows deleting zero or more documents from the collection.
	 *
	 * Some implementations may support {@see Collection\LimitableCommand} on deletes.
	 * Perform a type check on the returned {@see Command} object before applying a limit.
	 * Not all implementations may allow limits other than `0` (unlimited) or `1`.
	 *
	 * @since 1.0
	 * @see Collection\DeleteCommand
	 */
	public function startDelete(Predicate $filter): WriteCommand;

}
