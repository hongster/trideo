<?php defined('SYSPATH') or die('No direct script access.');

/**
 * @package Trideo
 * @category Model
 */
class Model_Credit extends ORM {
	
	protected $_updated_column = array('column' => 'updated_at', 'format' => TRUE);

	protected $_belongs_to = array(
		'User' => array(),
	);

} // Model_Credit