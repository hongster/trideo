<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Controller
 */
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

	public function action_update()
	{
		$user = ORM::factory('User', $this->_user_id);
		$errors = array();

		if ($this->request->method() == Request::POST)
		{
			$data = $this->request->post();
			$data['user_id'] = $this->_user_id;

			try
			{
				Membership::update_member($user, $data);
				return $this->redirect('member');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('models');
			}
		}
		else
		{
			$data = $user->as_array();
			unset($data['password']);
		}

		$this->template->title = 'Update Info';
		$this->view->set(array(
			'data' => $data,
			'errors' => $errors,
			'user_id' => $user->id,
		));
	}

} // Controller_Member
