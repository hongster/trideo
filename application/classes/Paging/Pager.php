<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Bootstrap pagination helper class.
 * 
 * @package Trideo
 * @category Helper
 */
class Paging_Pager {

	/** @var int Max result per page */
	public $page_size = 20;

	/** @var int */
	protected $current_page = 1;

	/** @var int Num of pages after query. */
	protected $num_pages = 0;

	/** @var array Result from query. */
	protected $result = array();

	/** Singletons */
	protected static $instances = array();

	protected function __construct() {}

	/**
	 * Multiple pager support. Each pager instance is identified by a name.
	 *
	 * @param string $name Instance identifier
	 * @return Pager
	 */
	public static function instance($name)
	{
		if ( ! isset(static::$instances[$name]))
		{
			static::$instances[$name] = new static;	
		}

		return static::$instances[$name];
	}

	/**
	 * @return int Number of pages of result.
	 */
	public function num_pages()
	{
		return $this->num_pages;
	}

	/**
	 * @return int Page number of current page, starting from 1.
	 */
	public function current_page()
	{
		return $this->current_page;
	}

	public function result()
	{
		return $this->result;
	}

	/**
	 * Perform query.
	 *
	 * @param Paging_Pagable $pagable Delegatee of query operation.
	 * @param array $query Search query (k-v pairs) to be passed to $pagable. 
	 * 	If this is not set, $_GET will be used.
	 * @return array Query result.
	 */
	public function query(Paging_Pagable $pagable, $query = NULL)
	{
		// If $query is not set, use $_GET
		is_array($query) OR $query = Request::current()->query();

		if (isset($query['page']))
		{
			$this->current_page = (int) $query['page'];
			unset($query['page']); // Pagable will not get to see this
		}
		else
		{
			$this->current_page = 1;
		}

		$limit = $this->page_size;
		$offset = ($this->current_page - 1) * $limit;

		$this->result = $pagable->query_result($query, $limit, $offset);
		$this->num_pages = $pagable->query_size($query) / $this->page_size;

		return $this->result;
	}

	/**
	 * Called in view, after `Pager::query` is performed in controller.
	 * 
	 * @param string $uri Optional. Query string will be added. Autodetect if 
	 * 	not set.
	 * @param string $query Optional. Will be converted to query string and 
	 * 	appended to URI.
	 * @return string HTML output of pagination.
	 */
	public function render($uri = NULL, $query = NULL)
	{
		is_null($uri) AND $uri = Request::current()->uri();
		is_null($query) AND $query = Request::current()->query();

		$output = '<ul class="pagination">';

		for ($i = 1; $i <= $this->num_pages; $i++)
		{
			if ($i == $this->current_page)
			{
				$output .= '<li class="active">';
				$output .= HTML::anchor('#', $i);
				$output .= '</li>';
			}
			else
			{
				$query['page'] = $i;
				$output .= '<li>';
				$output .= HTML::anchor($uri.URL::query($query), $i);
				$output .= '</li>';
			}
		}

		$output .= '</ul>';

		return $output;
	}

} // Paging_Pager