<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package ACL
 * @category Model
 */
class Model_ACL_User extends Model_SimpleAuth_User {

	protected $_has_one = array(
		'credit' => array(),
	);
	
	protected $_has_many = array(
		'roles' => array(
			'model' => 'Role',
			'through' => 'roles_users',
		),
	);
	
	/**
	 * @return bool
	 */
	public function is_admin()
	{
		return $this->has('roles', ORM::factory('Role', array('name' => 'admin')));
	}

} // Model_User