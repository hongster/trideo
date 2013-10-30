<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Controller
 */
class Controller_Access extends Trideo_Controller_Member {

	public function action_index()
	{
		$pager = new Paging_Pager;
		$query = $this->request->query();

		$query['user_id'] = $this->_user_id;
		$pager->query(ORM::factory('Access'), $query);

		$this->template->title = 'Access Log';
		$this->view->pager = $pager;
	}

	public function action_checkin()
	{
		$user_id = $this->_user_id;

		// Check if user already logged in
		$access = ORM::factory('Access')
			->where('user_id', '=', $user_id)
			->where('checkout', '=', NULL)
			->find();

		if ($access->loaded())
		{
			return $this->_flash_success('You has already checkin.', 'member');
		}

		$access->values(array('user_id' => $user_id, 'checkin' => time()))
			->save();

		return $this->_flash_success('Welcom to HSJB.', 'member');
	}

	public function action_checkout()
	{
		$charge = Access::checkout_user($this->_user_id);

		if ($charge === NULL)
		{
			return $this->_flash_error('You have not checkin yet.', 'member');
		}

		return $this->_flash_success("{$charge} credits deducted.", 'member');
	}

} // Controller_Admin_Transaction
