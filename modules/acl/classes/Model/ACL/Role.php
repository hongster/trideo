<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package ACL
 * @category Model
 */
class Model_ACL_Role extends ORM {
	
	protected $_has_many = array(
		'users' => array(
			'model' => 'User',
			'through' => 'roles_users',
		),
	);

} // Model_Role