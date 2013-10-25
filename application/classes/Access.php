<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 */
class Access {

	/**
	 * Ger record of last access for a user.
	 *
	 * @param Model_User|int $user
	 * @return Model_Access|NULL Return NULL if user has not access before.
	 */
	public static function last_access($user)
	{
		if ( ! $user instanceOf Model_User)
		{
			$user = ORM::factory('User', $user);
		}

		$access = $user->access
			->order_by('checkin', 'DESC')
			->find();

		return $access->loaded() ? $access : NULL;
	}

} // Access