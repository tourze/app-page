<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 云应用，主要是云笔记和云储存
 * 可用于二次开发的DEMO
 *
 * @author  YwiSax
 */

// 引用上相关模块
Kohana::module(array(
	'Database', // 最基础的数据库模块
	'ORM', // 为各模块提供ORM
	'Markdown', // Markdown语法处理
	'Storage', // 提供文件的存储方案
));

// 后台路由
Route::set('cloud-admin', 'admin/cloud(/<controller>(/<action>(/<params>))).html', array(
	    'controller' => 'note|file',
	    'params' => '.*',
	))
	->defaults(array(
		'controller' => 'Cloud',
		'action'     => 'index',
		'directory'  => 'Page/Cloud'
	));

