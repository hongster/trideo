<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package ACL
 * @category Model
 */
class Model_ACL_User extends Model_SimpleAuth_User {
	
	protected $_has_many = array(
		'roles' => array(
			'model' => 'Role',
			'through' => 'roles_users',
		),
	);
	
} // Model_User