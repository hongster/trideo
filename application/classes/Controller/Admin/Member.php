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

	public function action_create()
	{
		$data = $this->request->post();
		$errors = array();

		if ($this->request->method() == Request::POST)
		{
			$user = ORM::factory('User')->values($data);
			
			try
			{
				$user->check();
				$user->password = Auth::instance()->hash_password($user->password);
				$user->create();
				return $this->redirect('admin/member/info/'.$user->id);
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('models');
			}
		}

		$this->template->title = 'New Member';
		$this->view->set(compact('data', 'errors'));
	}

	/**
	 * Params:
	 *	- id User ID
	 */
	public function action_info()
	{
		$user = ORM::factory('User', $this->request->param('id'));

		$this->template->title = $user->name;
		$this->view->set(array(
			'user' => $user,
			'is_admin' => $user->is_admin(),
		));
	}

	/**
	 * Params:
	 *	- id User ID
	 */
	public function action_update()
	{
		$user = ORM::factory('User', $this->request->param('id'));
		$errors = array();

		if ($this->request->method() == Request::POST)
		{
			$data = $this->request->post();
			$change_password = ($data['password'] != '');

			if ( ! $change_password)
			{
				unset($data['password']);
			}

			$user->values($data);
			
			try
			{
				$user->check();
				
				if ($change_password)
				{
					$user->password = Auth::instance()->hash_password($user->password);
				}
				
				$user->update();

				return $this->redirect('admin/member/info/'.$user->id);
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

} // Controller_Admin_Member
