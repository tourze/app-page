<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 基于页的简单模块，最基础的应用级Module，一定要写好这个
 *
 * @author  YwiSax
 */

// 后台路由
Route::set('page-admin', 'admin/page/<controller>(/<action>(/<params>)).html', array(
	    //'controller' => 'element|layout|log|Page|Redirect|Snippet',
	    'params' => '.*',
	))
	->defaults(array(
		'controller' => 'Entry',
		'action'     => 'index',
		'directory'  => 'Page'
	));

// 默认路由
Route::set('default', '(<path>)', array(
		'path' => '.*',
	))
	->defaults(array(
		'controller' => 'Page',
		'action'     => 'view',
	));

