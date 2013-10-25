<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Controller/Admin
 */
class Controller_Admin_Access extends Trideo_Controller_Admin {

	public function action_index()
	{
		$pager = new Paging_Pager;
		$pager->query(ORM::factory('Access'), $this->request->query());

		$this->template->title = 'Access Log';
		$this->view->pager = $pager;
	}

	/**
	 * Params
	 *	- id User ID
	 */
	public function action_checkin()
	{
		$user_id = $this->request->param('id');

		// Check if user already logged in
		$access = ORM::factory('Access')
			->where('user_id', '=', $user_id)
			->where('checkout', '=', NULL)
			->find();

		if ($access->loaded())
		{
			return $this->_flash_success(
				'Member has already checkin.',
				'admin/member/info/'.$user_id);
		}

		$access->values(array('user_id' => $user_id, 'checkin' => time()))
			->save();

		return $this->_flash_success(
				'Member has checkin.',
				'admin/member/info/'.$user_id);
	}

	/**
	 * Params
	 *	- id User ID
	 */
	public function action_checkout()
	{
		$user_id = $this->request->param('id');

		// Check if user already logged in
		$access = ORM::factory('Access')
			->where('user_id', '=', $user_id)
			->where('checkout', '=', NULL)
			->find();

		if ( ! $access->loaded())
		{
			return $this->_flash_error(
				'Member has not checkin yet.',
				'admin/member/info/'.$user_id);
		}

		$access->values(array('user_id' => $user_id, 'checkout' => time()))
			->save();
		// TODO calculate cost

		return $this->_flash_success(
				'Member has checkout.',
				'admin/member/info/'.$user_id);
	}

} // Controller_Admin_Transaction
