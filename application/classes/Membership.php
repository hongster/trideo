<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Manage the user (member) records.
 * @package Trideo
 */
class Membership {

	/**
	 * Search by email addr and name. Returns a pager.
	 * 
	 * @param array $query
	 * @return Pagin_Pager
	 */
	public static function search(array $query)
	{
		$search = array('page' => Arr::get($query, 'page', 1));
		if ($q = Arr::get($query, 'q', FALSE))
		{
			$search['name'] = $q;
			$search['email'] = $q;
		}

		$pager = new Paging_Pager;
		$pager->query(ORM::factory('User'), $search);

		return $pager;
	}

} // Membership