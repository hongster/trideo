<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Trideo_Controller {

	public function action_index()
	{
		if (ACL::is_admin())
		{
			return $this->redirect('admin');
		}
		elseif (Auth::instance()->logged_in())
		{
			return $this->redirect('member');	
		}
	}

} // Controller_Main
