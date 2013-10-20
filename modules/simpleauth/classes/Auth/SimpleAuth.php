<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package SimpleAuth
 * @category Auth
 */
class Auth_SimpleAuth extends Auth {
	
	/**
	 * Logs a user in.
	 *
	 * @override
	 * @param string $email
	 * @param string $password
	 * @param bool $remember This is not supported.
	 * @return bool
	 */
	protected function _login($email, $password, $remember)
	{
		$user = ORM::factory('User', array(
				'email' => strtolower($email),
				'password' => $this->hash($password),
			));

		if ($user->loaded())
		{
			// Security: not storing password
			$user_array = $user->as_array();
			unset($user_array['password']);

			return $this->complete_login($user_array);
		}

		return FALSE;
	}

	/**
	 * Get the stored password for a username.
	 *
	 * @override
	 * @param string $username
	 * @return string
	 */
	public function password($username)
	{
		return ORM::factory('User')
			->where('username', '=', $username)
			->find()->password;
	}

	/**
	 * Check to see if the logged in user has the given password
	 *
	 * @override
	 * @param string $passwords
	 * @return bool 
	 */
	public function check_password($password)
	{
		$user = $this->get_user(NULL);

		if ($user == NULL)
			return FALSE;

		return ($this->hash($password) == $this->password($user['username']));
	}

}