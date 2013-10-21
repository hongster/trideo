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
			try
			{
				$user = Membership::create_member($data);
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
			
			try
			{
				Membership::update_member($user, $data);
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

	/**
	 * Promote user to admin status.
	 * Params:
	 *	- id User ID
	 */
	public function action_promote_admin()
	{
		$user = ORM::factory('User', $this->request->param('id'));

		if ( ! $user->is_admin())
		{
			$user->add('roles', ORM::factory('Role', array('name' => 'admin')));
		}

		return $this->_flash_success('Member promoted to admin.', 'admin/member/info/'.$user->id);
	}

	/**
	 * Params:
	 *	- id User ID
	 */
	public function action_demote_admin()
	{
		$user = ORM::factory('User', $this->request->param('id'));

		if ($user->id == 1)
		{
			$this->_flash_error('Cannot demote superadmin.', 'admin/member/info/'.$user->id);
		}

		if ($user->is_admin())
		{
			$user->remove('roles', ORM::factory('Role', array('name' => 'admin')));
		}

		return $this->_flash_success('Member demoted.', 'admin/member/info/'.$user->id);
	}

} // Controller_Admin_Member
