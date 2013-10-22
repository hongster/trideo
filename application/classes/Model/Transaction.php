<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Model
 */
class Model_Transaction extends ORM {
	
	protected $_created_column = array('column' => 'created_at', 'format' => TRUE);

	protected $_belongs_to = array(
		'user' => array(),
	);

} // Model_Transaction