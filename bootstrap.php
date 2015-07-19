<?php

use tourze\Base\Base;
use tourze\Base\Config;
use tourze\Base\Debug;
use tourze\Base\I18n;
use tourze\Base\Message;
use tourze\Route\Route;
use tourze\Tourze\Asset;
use tourze\View\View;

if ( ! defined('ROOT_PATH'))
{
    define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
}

require 'vendor/autoload.php';

// php文件后缀
defined('EXT') || define('EXT', '.php');

// 路径分隔符
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

// 判断是否在sae中
defined('IN_SAE') || define('IN_SAE', function_exists('sae_debug'));

Base::$cacheDir = ROOT_PATH . 'tmp/cache';
Base::$logConfig = [
    'file' => ROOT_PATH . 'tmp/log/' . date('Y/md') . '.log'
];

// 指定配置加载目录
Config::addPath(ROOT_PATH . 'config' . DIRECTORY_SEPARATOR);

// 语言文件目录
I18n::addPath(ROOT_PATH . 'i18n' . DIRECTORY_SEPARATOR);

// Message目录
Message::addPath(ROOT_PATH . 'message' . DIRECTORY_SEPARATOR);

// 指定视图加载目录
View::addPath(ROOT_PATH . 'view' . DIRECTORY_SEPARATOR);

// 激活调试功能
Debug::enable();

Asset::$version = '20150621';

// 指定控制器命名空间
Route::$defaultNamespace = '\\uc\\Controller\\';

if ( ! defined('UC_AUTH_COOKIE'))
{
    define('UC_AUTH_COOKIE', 'ucAuthKey');
}

if ( ! defined('UC_KEY'))
{
    define('UC_KEY', '');
}

// 路由定义
if ( ! defined('UC_PATH'))
{
    define('UC_PATH', '');
}

// 后台部分
Route::set('uc-admin', UC_PATH . 'admin(/<controller>(/<action>(/<id>)))')
    ->defaults([
        'directory'  => 'Admin',
        'controller' => 'User',
    ]);

// API部分
Route::set('uc-api', UC_PATH . 'api(/<controller>(/<action>(/<id>)))')
    ->defaults([
        'directory' => 'Api',
    ]);

// 用户重置密码
Route::set('uc-register', UC_PATH . 'user/register(-<action>(/<id>))')
    ->defaults([
        'directory'  => 'User',
        'controller' => 'Register',
        'action'     => 'index',
    ]);

// 用户重置密码
Route::set('uc-bind', UC_PATH . 'user/bind(-<action>(/<id>))')
    ->defaults([
        'directory'  => 'User',
        'controller' => 'Bind',
        'action'     => 'index',
    ]);

// 用户重置密码
Route::set('uc-reset', UC_PATH . 'user/reset(-<action>(/<id>))')
    ->defaults([
        'directory'  => 'User',
        'controller' => 'Reset',
        'action'     => 'index',
    ]);

// 用户通用部分
Route::set('uc-common', UC_PATH . '(<controller>(/<action>(/<id>)))')
    ->defaults([
        'controller' => 'User',
        'action'     => 'index',
    ]);
