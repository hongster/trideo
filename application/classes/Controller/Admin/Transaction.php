<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Controller/Admin
 */
class Controller_Admin_Transaction extends Trideo_Controller_Admin {

	/**
	 * List transaction records.
	 */
	public function action_history()
	{
		$pager = new Paging_Pager;
		$pager->query(ORM::factory('Transaction'), $this->request->query());

		$this->template->title = 'Transaction History';
		$this->view->pager = $pager;
	}

} // Controller_Admin_Transaction
