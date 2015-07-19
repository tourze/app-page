<?php defined('SYSPATH') OR die('No direct access allowed.');

// 后台路由
Route::set('cms-admin', 'admin/cms(/<controller>(/<action>(/<params>))).html', array(
	    'params' => '.*',
	))
	->defaults(array(
		'controller' => 'Model',
		'action'     => 'index',
		'directory'  => 'CMS'
	));

