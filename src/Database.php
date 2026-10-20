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
	 * Checks if the database implementation supports the given feature.
	 * @since 1.0
	 */
	public function supports(Database\Feature $feature): bool;

	/**
	 * Applies the given schema to the given collection, creating one if it does not yet exist.
	 *
	 * {@see Database\UpgradeOptions} can be used for more control over the behavior of the schema
	 * upgrade, such as which - if any - data losses to allow.
	 *
	 * Not all properties of the schema may be enforced by the database implementation.
	 * Use {@see ::supports()} to check which are supported.
	 *
	 * @since 1.0
	 * @param non-empty-string $collection The name of the collection for which to enforce the schema
	 */
	public function applySchema(string $collection, Schema $schema): Database\UpgradeCommand;

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
