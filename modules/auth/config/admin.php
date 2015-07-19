<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 扩展后台的菜单
 */
return array(

	'navigation' => array(
		__('Auth Manage') => array(
			'admin_route'		=> 'auth-admin',
			'admin_controller'	=> array('User', 'Role', 'Field', 'Module', 'Action'),
			'links' => array(
				__('User List')		=> Route::url('auth-admin', array('controller' => 'User', 'action' => 'list')),
				__('Field List')	=> Route::url('auth-admin', array('controller' => 'Field', 'action' => 'list')),
				__('Role List')		=> Route::url('auth-admin', array('controller' => 'Role', 'action' => 'list')),
				__('Module List')	=> Route::url('auth-admin', array('controller' => 'Module', 'action' => 'list')),
			),
		),
	),
);

