<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parent class for admin controllers.
 * @package Trideo
 * @category Controller
 */
class Trideo_Controller_Admin extends Trideo_Controller {

	public function before()
	{
		if ( ! ACL::is_admin())
		{
			return $this->_flash_error('Please login as administrator.', 'login');
		}
		
		parent::before();
	}

} // Trideo_Controller_Admin