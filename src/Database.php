<?php

namespace Slendium\Ocd;

/**
 * Data access object for the entire database.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Database {

	/**
	 * Returns all existing collections.
	 * @since 1.0
	 * @return list<non-empty-string>
	 */
	public function listCollections(): array;

	/**
	 * Checks if a collection by the given name exists.
	 * @since 1.0
	 * @param non-empty-string $name
	 */
	public function hasCollection(string $name): bool;

	/**
	 * Returns a specific collection, assuming it exists.
	 * @since 1.0
	 * @param non-empty-string $name
	 */
	public function getCollection(string $name): Collection;

	/**
	 * Deletes a collection and associated data.
	 * @since 1.0
	 * @param non-empty-string $name
	 */
	public function deleteCollection(string $name): void;

}
