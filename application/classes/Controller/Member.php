<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Member extends Trideo_Controller_Member {

	public function action_index()
	{
		$user = ORM::factory('User', $this->_user_id);

		$this->template->title = $user->name;
		$this->view->set(array(
			'user' => $user,
			'is_admin' => $user->is_admin(),
			'balance' => $user->credit->balance,
			'last_access' => Access::last_access($user),
		));
	}

} // Controller_Member
