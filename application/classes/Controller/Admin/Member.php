<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Member extends Trideo_Controller_Admin {

	public function action_index()
	{
		$file = '';
		if ($directory = $this->request->directory())
		{
			$file = $directory;
		}
		$file .= DIRECTORY_SEPARATOR.$this->request->controller();
		$file .= DIRECTORY_SEPARATOR.$this->request->action();
		echo $file;
	}

} // Controller_Admin_Member
