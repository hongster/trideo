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

	/**
	 * Add new member.
	 *
	 * @param array $data Member info.
	 * @return Model_User
	 * @throws ORM_Validation_Exception
	 */
	public static function create_member(array $data)
	{
		$user = ORM::factory('User')->values($data);
			
		$user->check(); // Might throw ORM_Validation_Exception
		$user->password = Auth::instance()->hash_password($user->password);
		$user->create();

		// Create credit account
		$credit = ORM::factory('Credit');
		$credit->user_id = $user->id;
		$credit->balance = 0;
		$credit->updated_at = time();
		$credit->create();

		return $user;
	}

	/**
	 * Update basic info. Password remains unchanged if input is empty.
	 *
	 * @param Model_User $user.
	 * @param array $data Member info.
	 * @throws ORM_Validation_Exception
	 */
	public static function update_member(Model_User $user, array $data)
	{
		$change_password = (Arr::get($data, 'password', '') != '');

		if ( ! $change_password)
		{
			unset($data['password']);
		}

		$user->values($data);
		
		$user->check(); // Might throw ORM_Validation_Exception
			
		if ($change_password)
		{
			$user->password = Auth::instance()->hash_password($user->password);
		}
		
		$user->update();
	}

} // Membership