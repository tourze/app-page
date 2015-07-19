<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 扩展后台的菜单
 */
return array(

	'navigation' => array(
		__('CMS Manage') => array(
			'admin_route'		=> 'cms-admin',
			'admin_controller'	=> array('Model', 'Field', 'Entry'),
			'links' => array(
				__('CMS Field')		=> Route::url('cms-admin', array('controller' => 'Field')),
				__('CMS Model')		=> Route::url('cms-admin', array('controller' => 'Model')),
				__('CMS Entry')		=> Route::url('cms-admin', array('controller' => 'Entry')),
			),
		),
	),
);

