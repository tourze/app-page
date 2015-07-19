<?php defined('SYSPATH') OR die('No direct script access.');

// 加载必要的类
require Kohana::find_file('vendor', 'weibo/saetv2');

// 权限管理控制器
Route::set('weibo-admin', 'admin/weibo/<controller>(/<action>(/<params>)).html', array(
	    'params' => '.*',
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Weibo',
	));

/**
 * 下面是自定义路由
 */
// 回调地址
Route::set('weibo-callback', 'weibo-callback.html')
	->defaults(array(
		'controller' => 'Weibo',
		'action' => 'callback',
	));
// 发布微博
Route::set('weibo-post', 'weibo-post.html')
	->defaults(array(
		'controller' => 'Weibo',
		'action' => 'post',
	));
// 微博表情
Route::set('weibo-emotions', 'weibo-emotions.html')
	->defaults(array(
		'controller' => 'Weibo',
		'action' => 'emotions',
	));
// 传送微博
Route::set('weibo-send', 'weibo-send.html')
	->defaults(array(
		'controller' => 'Weibo',
		'action' => 'send',
	));
	
// 微博图片
Route::set('weibo-upload', 'weibo-upload.html')
	->defaults(array(
		'controller' => 'Weibo',
		'action' => 'upload',
	));

// 加载那些配置啦
Kohana::$config->load('weibo');

