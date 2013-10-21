<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Controller/Admin
 */
class Controller_Admin_Member extends Trideo_Controller_Admin {

	public function action_index()
	{
		$this->template->title = 'Members';
		$pager = Membership::search($this->request->query());
		$this->view->pager = $pager;
	}

} // Controller_Admin_Member
