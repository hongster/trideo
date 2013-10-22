<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Controller/Admin
 */
class Controller_Admin_Credit extends Trideo_Controller_Admin {

	/**
	 * Params
	 *	- id User ID
	 */
	public function action_purchase()
	{
		$user = ORM::factory('User', $this->request->param('id'));		
		$data = $this->request->post();
		$errors = array();

		if ($this->request->method() == Request::POST)
		{
			$validation = Validation::factory($data);
			$validation->rules('amount', $this->_purchase_rules());

			if ($validation->check())
			{
				$added = Credit::purchase_credits($user, $data['amount']);
				return $this->_flash_success(
					"{$added} credits added.",
					'admin/member/info/'.$user->id);
			}

			$errors = $validation->errors('credit/purchase');
		}

		$this->template->title = 'Purchase Credits';
		$this->view->set(array(
			'data' => $data,
			'errors' => $errors,
			'user' => $user,
			'credit' => $user->credit,
			'price_options' => Credit::$rates,
		));
	}

	/**
	 * @return array
	 */
	protected function _purchase_rules()
	{
		return array(
			array('not_empty'),
			array('in_array', array(':value', array_keys(Credit::$rates))),
		);
	}

} // Controller_Admin_Credit
