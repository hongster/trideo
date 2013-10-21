<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Session extends Trideo_Controller {

	public function before()
	{
		if ($this->request->action() == 'logout')
		{
			$this->auto_render = FALSE;
		}

		parent::before();
	}

	public function action_login()
	{
		$login_failed = FALSE;
		$data = $this->request->post();

		if ($this->request->method() == Request::POST)
		{
			$success = Auth::instance()->login($this->request->post('email'), $this->request->post('password'));
			if ($success)
			{
				$uri = ACL::is_admin() ? 'admin' : '';
				return $this->redirect($uri);
			}
			else
			{
				$login_failed = TRUE;
			}
		}

		$this->view->set(compact('login_failed', 'data'));
	}

	public function action_logout()
	{
		Auth::instance()->logout();
		return $this->redirect('');
	}

} // Controller_Session
