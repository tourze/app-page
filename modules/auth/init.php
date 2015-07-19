<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 一个基于数据库实现的权限管理系统
 * 目前只支持ORM（MySQL），以后可能会考虑LDAP什么的实现
 * 或者跟第三方结合的实现。例如UCenter
 */

// 权限管理控制器
Route::set('auth-admin', 'admin/auth/<controller>(/<action>(/<params>)).html', array(
	    'params' => '.*',
	))
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'Auth',
	));

// 用户动作控制器
Route::set('auth-action', 'auth/<action>(-<id>).html', array(
		'action' => 'register|login|logout|view|setting|reset|avatar|popuser|callback',
		'id' => '\d+',
	))
	->defaults(array(
		'controller' => 'User',
	));

