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

		$file = '';
		if ($directory = $this->request->directory())
		{
			$file = $directory;
		}
		$file .= DIRECTORY_SEPARATOR.$this->request->controller();
		$file .= DIRECTORY_SEPARATOR.$this->request->action();
		
		try
		{
			$this->view = View::factory($file);
			$this->template->content = $this->view;
		}
		catch (View_Exception $e)
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
	 * Flash message, redirect if URL is specified.
	 *
	 * @param string $type
	 * @param string $message
	 * @param string $url Optional redirection URL.
	 */
	protected function _flash_message($type, $message, $url = NULL)
	{
		Session::instance()->set($type, $message);

		if ($url !== NULL)
		{
			return $this->redirect($url);
		}
	}

	/**
	 * Flash informational message.
	 *
	 * @param string $message
	 * @param string $url Optional redirection URL.
	 */
	protected function _flash_info($message, $url = NULL)
	{
		$this->_flash_message(static::MESSAGE_INFO, $message, $url);
	}

	/**
	 * Flash success message.
	 *
	 * @param string $message
	 * @param string $url Optional redirection URL.
	 */
	protected function _flash_success($message, $url = NULL)
	{
		$this->_flash_message(static::MESSAGE_SUCCESS, $message, $url);
	}

	/**
	 * Flash error message.
	 *
	 * @param string $message
	 * @param string $url Optional redirection URL.
	 */
	protected function _flash_error($message, $url = NULL)
	{
		$this->_flash_message(static::MESSAGE_ERROR, $message, $url);
	}

} // Trideo_Controller