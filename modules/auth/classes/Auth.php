<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 用户权限认证模块，处理用户的登入登出和密码维护
 *
 * @package    Kohana/Auth
 */
abstract class Auth {

	const DEFAULT_DRIVER = 'ORM';

	const DEFAULT_CONFIG = 'default';

	// 单一实例
	protected static $_instance = array();

	/**
	 * 单例模式入口
	 *
	 * @return Auth
	 */
	public static function instance($group = NULL)
	{
		if ($group === NULL)
		{
			$group = Auth::DEFAULT_CONFIG;
		}
		if ( ! isset(Auth::$_instance[$group]))
		{
			// 加载指定类型的配置
			$config = Kohana::$config->load('auth')->get($group);
			if ( ! isset($config['driver']))
			{
				$config['driver'] = Auth::DEFAULT_DRIVER;
			}
			Auth::$_instance[$group] = Auth_Driver::factory($config);
		}

		return Auth::$_instance[$group];
	}

	/**
	 * 判断用户是否登陆
	 */
	public static function logged_in()
	{
		return Auth::instance()->logged_in();
	}

}

