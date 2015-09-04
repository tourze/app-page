<?php

use tourze\Base\Config;
use tourze\Base\I18n;
use tourze\Base\Message;
use tourze\Route\Route;
use tourze\View\View;

require_once 'vendor/autoload.php';

if ( ! defined('ROOT_PATH'))
{
    define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
}

// 指定配置加载目录
Config::addPath(ROOT_PATH . 'config' . DIRECTORY_SEPARATOR);

// 语言文件目录
I18n::addPath(ROOT_PATH . 'i18n' . DIRECTORY_SEPARATOR);

// Message目录
Message::addPath(ROOT_PATH . 'message' . DIRECTORY_SEPARATOR);

// 指定视图加载目录
View::addPath(ROOT_PATH . 'view' . DIRECTORY_SEPARATOR);

// 指定控制器命名空间
Route::$defaultNamespace = '\\page\\Controller\\';

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

