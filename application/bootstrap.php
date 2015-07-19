<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

if ( ! defined('IN_SAE'))
{
	define('IN_SAE', function_exists('sae_debug'));
}

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Asia/Chongqing');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

// sae不支持ini_set
if ( ! IN_SAE)
{
	/**
	 * Enable the Kohana auto-loader for unserialization.
	 *
	 * @link http://www.php.net/manual/function.spl-autoload-call
	 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
	 */
	ini_set('unserialize_callback_func', 'spl_autoload_call');
}

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

// 运行环境配置
if ($_SERVER['HTTP_HOST'] == 'www.luzhongpeng.com')
{
	// 开发环境
	Kohana::$environment = Kohana::PRODUCTION;
}
else
{
	// 发布环境啊
	Kohana::$environment = Kohana::DEVELOPMENT;
}

// 如果是生产环境，那么返回的错误信息为空
if (Kohana::$environment == Kohana::PRODUCTION)
{
	// 发布环境关闭错误提示
	error_reporting(0);
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => '/',
	'index_file'	=> FALSE,
	'caching'		=> (Kohana::$environment == Kohana::DEVELOPMENT ? FALSE : TRUE),
	'cache_life'	=> 300,
	'profile'		=> (Kohana::$environment == Kohana::DEVELOPMENT ? TRUE : FALSE),
	'error'			=> (Kohana::$environment == Kohana::DEVELOPMENT ? TRUE : FALSE),
	'expose'		=> TRUE,
));

/**
 * 设置Cookie盐
 */
Cookie::$salt = 'f8/*#B=+^f_ne93)|Y';

/**
 * 设置语言
 */
I18N::lang('zh-cn');

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'helper'		=> MODPATH.'helper',

	'cache'			=> MODPATH.'cache',      // Caching with multiple backends
	'database'		=> MODPATH.'database',   // Database access
	'mysqli'		=> MODPATH.'mysqli',
	'orm'			=> MODPATH.'orm',        // Object Relationship Mapping
	'orm-mptt'		=> MODPATH.'orm-mptt',
	'captcha'		=> MODPATH.'captcha',
	'markdown'		=> MODPATH.'markdown',
	'twig'			=> MODPATH.'twig',
	'pagination'	=> MODPATH.'pagination',
	'image'			=> MODPATH.'image',      // Image manipulation
	'media'			=> MODPATH.'media',
	
	'userguide'		=> MODPATH.'userguide',  // User guide and API documentation

	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool

	// 'minion'     => MODPATH.'minion',     // CLI Tasks
	// 'unittest'   => MODPATH.'unittest',   // Unit testing

	'admin'			=> MODPATH.'admin',
	'socialbbs'		=> MODPATH.'socialbbs',		// 社会化论坛
	'qrcode'		=> MODPATH.'qrcode',		// 二维码
	'weibo'			=> MODPATH.'weibo',			// 树洞发布端
	'gduf'			=> MODPATH.'gduf',			// 广金邮箱
	'auth'			=> MODPATH.'auth',
	'cms'			=> MODPATH.'cms',
	'page'			=> MODPATH.'page',
));

// Log功能涉及IO，在SAE中可以暂时注释
if ( ! IN_SAE)
{
	/**
	 * Attach the file write to logging. Multiple writers are supported.
	 */
	Kohana::$log->attach(new Log_File(APPPATH.'logs'));
}

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
try
{
	// 尝试获取默认路由
	$route = Route::get('default');
}
catch (Kohana_Exception $e)
{
	Route::set('default', '(<controller>(/<action>(/<id>)))')
		->defaults(array(
			'controller' => 'welcome',
			'action'     => 'index',
		));
}

