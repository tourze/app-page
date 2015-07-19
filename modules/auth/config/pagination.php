<?php defined('SYSPATH') OR die('No direct script access.');

return array(
	'admin_auth_user_list' => array(
		'current_page'      => array('source' => 'query_string', 'key' => 'page'), // source: "query_string"或"route"
		'total_items'       => 0,
		'items_per_page'    => 10,
		'view'              => 'pagination/digg',
		'auto_hide'         => TRUE,
		'first_page_in_url' => FALSE,
	),
);

