<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Parent class for logged in user controllers.
 * @package Trideo
 * @category Controller
 */
class Trideo_Controller_Member extends Trideo_Controller {

	/** @var int Logged in user's ID. */
	protected $_user_id;

	public function before()
	{
		if ( ! Auth::instance()->logged_in())
		{
			return $this->_flash_error('Login is required.', 'login');
		}
		
		$this->_user_id = Arr::get(Auth::instance()->get_user(), 'id');

		parent::before();
	}

} // Trideo_Controller_Member