<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Interface to be implemented by models that support paging.
 * 
 * @package Trideo
 * @category Helper
 */
interface Paging_Pagable {

	/**
	 * Perform query and return result.
	 * 
	 * @param array $query
	 * @param int $limit
	 * @param int $offset
	 * @return array Query result.
	 */
	public function query_result(array $query, $limit, $offset);

	/**
	 * Count number of results in total.
	 * 
	 * @param array $query
	 * @return int Result size.
	 */
	public function query_size(array $query);

} // Paging_Pagable