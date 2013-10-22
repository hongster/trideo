<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Model
 */
class Model_User extends Model_ACL_User implements Paging_Pagable {
	
	protected $_has_one = array(
		'credit' => array(),
	);

	protected $_has_many = array(
		'roles' => array(
			'model' => 'Role',
			'through' => 'roles_users',
		),

		'transactions' => array(),
	);

	/**
	 * @override
	 * @return array
	 */
	public function rules()
	{
		$rules = array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 100)),
			),

			'email' => array(
				array('not_empty'),
				array('max_length', array(':value', 30)),
				array('email'),
				array(array($this, 'unique_email')),
			),

			'password' => array(
				array('min_length', array(':value', 6)),
			),

			'contact_num' => array(
				array('max_length', array(':value', 30)),
			),
		);

		// Password is optional when uploading existing record
		if ( ! $this->loaded())
		{
			$rules['password'][] = array('not_empty');
		}

		return $rules;
	}

	/**
	 * @override
	 * @return array
	 */
	public function filters()
	{
		return array(
			'name' => array(
				array('trim'),
			),

			'email' => array(
				array('trim'),
				array('strtolower'),
			),
		);
	}

	/**
	 * Validation function.
	 *
	 * @param string $email
	 * @return bool
	 */
	public function unique_email($email)
	{
		$db = DB::select(array(DB::expr('COUNT(id)'), 'size'))
			->from($this->_table_name)
			->where('email', '=', $email);

		if ($this->loaded())
		{
			$db->where('id', '<>', $this->id);
		}
			
		return $db->execute()->get('size') == 0;
	}

	/**
	 * NOTE: LIKE search.
	 * @override
	 */
	public function query_result(array $query, $limit, $offset)
	{
		$customer = ORM::factory('User');
		foreach ($query as $field => $value)
		{
			$customer->or_where($field, 'like', "%{$value}%");
		}

		return $customer
			->order_by('name', 'ASC')
			->limit($limit)
			->offset($offset)
			->find_all();
	}

	/**
	 * NOTE: LIKE search.
	 * @override
	 */
	public function query_size(array $query)
	{
		$db = DB::select(array(DB::expr('COUNT(id)'), 'size'))
			->from($this->_table_name);
		
		foreach ($query as $field => $value)
		{
			$db->or_where($field, 'like', "%{$value}%");
		}

		return $db->execute()->get('size', 0);
	}

} // Model_User