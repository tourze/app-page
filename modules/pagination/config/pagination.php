<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	// 默认分页配置
	'default' => array(
		'current_page'      => array('source' => 'query_string', 'key' => 'page'), // source: "query_string"或"route"
		'total_items'       => 0,
		'items_per_page'    => 10,
		'view'              => 'pagination/basic',
		'auto_hide'         => TRUE,
		'first_page_in_url' => TRUE,
	),
);

