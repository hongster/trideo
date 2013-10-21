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

		return ORM::factory('User', $user['id'])->is_admin();
	}

} // ACL