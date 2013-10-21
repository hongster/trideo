<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Model
 */
class Model_User extends Model_ACL_User implements Paging_Pagable {
	
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