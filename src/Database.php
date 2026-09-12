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
	 * Enforces the given schema for the given collection, creating one if it does not yet exist.
	 *
	 * {@see Database\UpgradeOptions} can be used for more control over the behavior of the schema
	 * upgrade, such as which - if any - data losses to allow.
	 *
	 * @since 1.0
	 * @param non-empty-string $collection
	 */
	public function enforceSchema(string $collection, Schema $schema): Database\UpgradeCommand;

	/**
	 * Returns all existing collections.
	 * @since 1.0
	 * @return iterable<non-empty-string,Collection>
	 */
	public function listCollections(): iterable;

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
