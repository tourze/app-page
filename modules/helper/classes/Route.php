<?php defined('SYSPATH') OR die('No direct script access.');

class Route extends Kohana_Route {

	/**
	 * 扩展URI方法，让所有controller名称都为小写
	 */
	public function uri(array $params = NULL)
	{
		if (isset($params['controller']))
		{
			$params['controller'] = strtolower($params['controller']);
		}
		return parent::uri($params);
	}

}

