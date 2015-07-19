<?php defined('SYSPATH') OR die('No direct script access.');

// 后台路由
Route::set('admin', 'admin/<action>(/<params>).html', array(
		'action'	=> 'login|logout',
	    'params'	=> '.*',
	))
	->defaults(array(
		'controller' => 'Admin',
		'action'     => 'index',
	));

