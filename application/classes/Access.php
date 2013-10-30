<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 */
class Access {

	/**
	 * @param Model_User $user
	 * @throws Kohana_Exception If user ran out of credit.
	 */
	public static function checkin_user(Model_User $user)
	{
		if ($user->credit->balance <= 0)
		{
			throw new Kohana_Exception('Member has ran out of credit.');
		}

		$access = static::last_access($user);

		if ($access && ( ! $access->checkout))
		{
			return; // Already checkin
		}

		return ORM::factory('Access')
			->values(array(
				'user_id' => $user->id,
				'checkin' => time(),
			))
			->create();
	}

	/**
	 * @param Model_User|int
	 * @return int Number of credits charged.
	 */
	public static function checkout_user($user)
	{
		if ( ! $user instanceOf Model_User)
		{
			$user = ORM::factory('User', $user);
		}

		$access = static::last_access($user);

		if (is_null($access) || $access->checkout)
		{
			return NULL; // Member has no checkin yet
		}

		$access->checkout = time();
		$access->update();

		return Credit::charge_access($access);
	}

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