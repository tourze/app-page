<?php

use tourze\Route\Route;

/**
 * 扩展后台的菜单
 */
return [

    'navigation' => array(
        __('Page Manage') => array(
            'admin_route'		=> 'page-admin',
            'admin_controller'	=> array('Entry', 'Snippet', 'Layout', 'Redirect'),
            'links' => array(
                __('Page Entry')		=> Route::url('page-admin', array('controller' => 'Entry')),
                __('Snippet Manage')	=> Route::url('page-admin', array('controller' => 'Snippet')),
                __('Layout Manage')		=> Route::url('page-admin', array('controller' => 'Layout')),
                __('Redirect Manage')	=> Route::url('page-admin', array('controller' => 'Redirect')),
            ),
        ),
    ),

    'users' => [
        'admin'  => '@@qq.123',
        'ywisax' => 'Ladder19',
    ],

];
