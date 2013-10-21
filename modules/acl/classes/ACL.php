<?php defined('SYSPATH') or die('No direct script access.');

class ACL {
	
	/**
	 * Determine if user is an administrator.
	 *
	 * @return bool
	 */
	public static function is_admin()
	{
		if ( ! ($user = Auth::instance()->get_user()))
			return FALSE;

		$user = ORM::factory('User', $user['id']);

		return $user->has('roles', ORM::factory('Role', array('name' => 'admin')));
	}

} // ACL