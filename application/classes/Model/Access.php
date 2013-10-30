<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Model
 */
class Model_Access extends ORM implements Paging_Pagable {
	
	protected $_belongs_to = array(
		'user' => array(),
	);

	/**
	 * @override
	 * 
	 * @param array $query
	 * @param int $limit
	 * @param int $offset
	 * @return array Query result.
	 */
	public function query_result(array $query, $limit, $offset)
	{
		$model = ORM::factory('Access');
		$this->_build_query($query, $model);
		
		return $model
			->order_by('checkin', 'DESC')
			->limit($limit)
			->offset($offset)
			->find_all();
	}

	/**
	 * @override
	 * 
	 * @param array $query
	 * @return int Result size.
	 */
	public function query_size(array $query)
	{
		$db = DB::select(array(DB::expr('COUNT(id)'), 'size'))
			->from($this->_table_name);
		$this->_build_query($query, $db);

		return $db->execute()->get('size', 0);
	}

	/**
	 * Parse query array and construct query.
	 * 
	 * @param array $query
	 * @param mixed $db Can be either Database_Query_Builder_Select	or ORM
	 */
	protected function _build_query(array $query, $db)
	{
		foreach ($query as $field => $value)
		{
			switch ($field)
			{
				case 'user_id':
					$db->or_where('user_id', '=', $value);
				break;

				case 'before':
					$db->or_where('checkout', '<=', $value);
				break;

				case 'after':
					$db->or_where('checkin', '>=', $value);
				break;
			}
		}
	}

	/**
	 * Calculate accumulated access time.
	 *
	 * @param int $start Inclusive.
	 * @param int $end Exclusive.
	 * @param int $user_id
	 * @return int In seconds.
	 */
	public function accumulated_duration($start, $end, $user_id)
	{
		$models = ORM::factory('Access')
			->where('checkin', '>=', $start)
			->where('checkout', '<', $end)
			->where('user_id', '=', $user_id)
			->find_all();

		$duration = 0;
		foreach ($models as $access)
		{
			$duration += ($access->checkout - $access->checkin);
		}

		return $duration;
	}

} // Model_Access