<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package SimpleAuth
 * @category Model
 */
class Model_User extends Model_SimpleAuth_User {
	
	protected $_created_column = array('column' => 'created_at', 'format' => TRUE);
	protected $_updated_column = array('column' => 'updated_at', 'format' => TRUE);
	
} // Model_User