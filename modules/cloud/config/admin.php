<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 扩展后台的菜单
 */
return array(

	'navigation' => array(
		__('Cloud Manage') => array(
			'admin_route'		=> 'cloud-admin',
			'admin_controller'	=> array('Note', 'File'),
			'links' => array(
				__('Cloud Note')		=> Route::url('cloud-admin', array('controller' => 'Note')),
				__('Cloud File')		=> Route::url('cloud-admin', array('controller' => 'File')),
			),
		),
	),
);

