<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Controller
 */
class Trideo_Controller extends Controller_Template {

	// Session keys for flashing message
	const MESSAGE_INFO = 'TEMPLATE_MESSAGE_INFO';
	const MESSAGE_SUCCESS = 'TEMPLATE_MESSAGE_SUCCESS';
	const MESSAGE_ERROR = 'TEMPLATE_MESSAGE_ERROR';

	/** @var View Access to template content. */
	public $view;

	/**
	 * Setup $this->view
	 *
	 * @override
	 */
	public function before()
	{
		parent::before();

		if ( ! $this->auto_render)
		{
			return;
		}

		$file = $this->request->controller()
			.DIRECTORY_SEPARATOR.$this->request->action();
		
		try
		{
			$this->view = View::factory($file);
			$this->template->content = $this->view;
		}
		catch (View_Exception $ex)
		{
			// View file not available
		}
	}

	/**
	 * Set flash messages. 
	 * 
	 * @override
	 */
	public function after()
	{
		if ($this->auto_render)
		{
			$session = Session::instance();
			if ($message = $session->get_once(static::MESSAGE_ERROR, FALSE))
			{
				$this->template->flash_error = $message;
			}

			if ($message = $session->get_once(static::MESSAGE_SUCCESS, FALSE))
			{
				$this->template->flash_success = $message;
			}

			if ($message = $session->get_once(static::MESSAGE_INFO, FALSE))
			{
				$this->template->flash_info = $message;
			}
		}

		parent::after();
	}

	/**
	 * Flash informational message.
	 *
	 * @param string $message
	 */
	protected function _flash_info($message)
	{
		Session::instance()->set(static::MESSAGE_INFO, $message);
	}

	/**
	 * Flash success message.
	 *
	 * @param string $message
	 */
	protected function _flash_success($message)
	{
		Session::instance()->set(static::MESSAGE_SUCCESS, $message);
	}

	/**
	 * Flash error message.
	 *
	 * @param string $message
	 */
	protected function _flash_error($message)
	{
		Session::instance()->set(static::MESSAGE_ERROR, $message);
	}

} // Trideo_Controller