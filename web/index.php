<?php

use tourze\Base\Base;
use tourze\Bootstrap\Bootstrap;
use tourze\Flow\Flow;
use tourze\Route\Route;

require '../bootstrap.php';

// 提交新内容
Route::set('submit', 'submit')
    ->defaults([
        'controller' => 'Page',
        'action'     => 'submit',
    ]);

// 默认路由
Route::set('default', '(<path>)', ['path' => '.*'])
    ->defaults([
        'controller' => 'Page',
        'action'     => 'view',
    ]);

/**
 * SDK启动
 */
$app = Base::instance();

// 主工作流
$flow = Flow::instance('sdk');
$flow->contexts = [
    'app' => $app,
];
$flow->layers = Bootstrap::$layers;
$flow->start();
