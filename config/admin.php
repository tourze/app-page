<?php

use tourze\Route\Route;

/**
 * 扩展后台的菜单
 */
return [

    'navigation' => [
        __('Base Manage') => [
            'admin_route'      => 'page-admin',
            'admin_controller' => ['Entry', 'Snippet', 'Layout', 'Redirect'],
            'links'            => [
                __('Base Entry')      => Route::url('page-admin', ['controller' => 'Entry']),
                __('Snippet Manage')  => Route::url('page-admin', ['controller' => 'Snippet']),
                __('Layout Manage')   => Route::url('page-admin', ['controller' => 'Layout']),
                __('Redirect Manage') => Route::url('page-admin', ['controller' => 'Redirect']),
            ],
        ],
    ],

    'users'      => [
        'admin'  => '@@qq.123',
        'ywisax' => 'Ladder19',
    ],

];
