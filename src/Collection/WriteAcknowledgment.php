<?php

namespace Slendium\Ocd\Collection;

/**
 * The level of "acknowledgment" that needs to be awaited by a write command before it is considered
 * successful.
 *
 * Implementations that don't support a certain level of write acknowledgment should assume the nearest
 * level that they do support.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
enum WriteAcknowledgment {

	/**
	 * Does not wait for any confirmation of the write succeeding.
	 * Reports on database connection issues at best.
	 * @since 1.0
	 */
	case None;

	/**
	 * Waits until the database instance wrote the changes into memory successfully.
	 * @since 1.0
	 */
	case InMemory;

	/**
	 * Waits until the database instance wrote the changes to disk successfully.
	 * @since 1.0
	 */
	case OnDisk;

	/**
	 * Waits until at least one other database instance has replicated the changes.
	 * @since 1.0
	 */
	case Replicated;

	/**
	 * Waits until a majority of database instances has replicated the changes.
	 * @since 1.0
	 */
	case MajorityReplicated;

}
