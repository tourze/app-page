<?php defined('SYSPATH') OR die('No direct access.');
/**
 * 验证码抽象类
 *
 * @package		Kohana/Captcha
 * @cateogry	Base
 * @author		YwiSax
 */
class Kohana_Captcha {

	const DEFAULT_GROUP = 'default';

	/**
	 * @var  object  验证码实例
	 */
	public static $instance;

	/**
	 * 验证码的单例
	 *
	 * @param   string  $group  配置组名
	 * @return  object
	 */
	public static function instance($group = NULL)
	{
		if ( ! $group)
		{
			$group = Captcha::DEFAULT_GROUP;
		}
		if ( ! isset(Captcha::$instance))
		{
			// 加载配置文件
			$config = Kohana::$config->load('captcha')->get($group);
			if ( ! $config)
			{
				throw new Captcha_Exception('The requested captcha group ":group" not found.', array(
					':group' => $group,
				));
			}
			// 新建实例
			Captcha::$instance = Captcha_Driver::factory($config, $group);
			register_shutdown_function(array(Captcha::$instance, 'update_response_session'));
		}

		return Captcha::$instance;
	}

	/**
	 * 校验输入的验证码
	 *
	 * @param  string  $response  用户的输入
	 * @return boolean
	 */
	public static function valid($response)
	{
		// 记录尝试次数
		static $counted;
		// User has been promoted, always TRUE and don't count anymore
		if (Captcha::instance()->promoted())
		{
			return TRUE;
		}
		// Challenge result
		$result = (bool) (sha1(strtoupper($response)) === Session::instance()->get('captcha_response'));
		// Increment response counter
		if ($counted !== TRUE)
		{
			$counted = TRUE;
			// 验证码有效
			if ($result === TRUE)
			{
				Captcha::instance()->valid_count(Session::instance()->get('captcha_valid_count') + 1);
			}
			// 验证码无效
			else
			{
				Captcha::instance()->invalid_count(Session::instance()->get('captcha_invalid_count') + 1);
			}
		}
		return $result;
	}
}

