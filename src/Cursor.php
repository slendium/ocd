<?php

namespace Slendium\Ocd;

use Slendium\Ocd\Cursor\Filterable;
use Slendium\Ocd\Cursor\Scrollable;
use Slendium\Ocd\Query\Predicate;

/**
 * Contains methods for manipulating cursors.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class Cursor {

	/**
	 * @since 1.0
	 * @template T of Filterable
	 * @param T $source
	 * @return T
	 */
	public static function filter(Filterable $source, Predicate $filter): Filterable {
		$source->filter = $filter;
		return $source;
	}

	/**
	 * @since 1.0
	 * @template T of Scrollable
	 * @param T $source
	 * @param int<0,max> $skip
	 * @return T
	 */
	public static function skip(Scrollable $source, int $skip): Scrollable {
		$source->skip = $skip;
		return $source;
	}

	/**
	 * @since 1.0
	 * @template T of Scrollable
	 * @param T $source
	 * @param int<0,max> $limit
	 * @return T
	 */
	public static function limit(Scrollable $source, int $limit): Scrollable {
		$source->limit = $limit;
		return $source;
	}

	/**
	 * @since 1.0
	 * @template T of Scrollable
	 * @param T $source
	 * @param int<0,max> $skip
	 * @param int<0,max> $limit
	 * @return T
	 */
	public static function scroll(Scrollable $source, int $skip, int $limit): Scrollable {
		$source->skip = $skip;
		$source->limit = $limit;
		return $source;
	}

	private function __construct() { }

}
