<?php defined('SYSPATH') OR die('No direct script access.');

class ORM extends Kohana_ORM {

	protected $_table_names_plural = FALSE;
	
	protected $_object_plural = FALSE;

	public function where($column, $op, $value)
	{
		// 默认是当前对象的字段
		if (strpos($column, '.') === FALSE)
		{
			$column = $this->_object_name.'.'.$column;
		}
		return parent::where($column, $op, $value);
	}

	public function label($key)
	{
		$labels = $this->labels();
		return isset($labels[$key]) ? $labels[$key] : $key;
	}

}

