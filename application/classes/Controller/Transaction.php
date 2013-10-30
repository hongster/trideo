<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Controller
 */
class Controller_Transaction extends Trideo_Controller_Member {

	/**
	 * List transaction records.
	 */
	public function action_index()
	{
		$pager = new Paging_Pager;
		$query = $this->request->query();

		$query['user_id'] = $this->_user_id;
		$pager->query(ORM::factory('Transaction'), $query);

		$this->template->title = 'Transaction History';
		$this->view->pager = $pager;
	}

} // Controller_Admin_Transaction
