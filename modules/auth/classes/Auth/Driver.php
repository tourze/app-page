<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Auth驱动类
 *
 * @package    Kohana/Auth
 * @author     YwiSax
 */
abstract class Auth_Driver {

	const CLASS_PREFIX = 'Auth_Driver_';

	public static function factory($config)
	{
		if ( ! isset($config['driver']))
		{
			$config['driver'] = Auth::DEFAULT_DRIVER;
		}
		$class = Auth_Driver::CLASS_PREFIX . ucfirst($config['driver']);
		// 创建指定类型的实例
		return new $class($config);
	}

	protected $_session;

	protected $_config;

	/**
	 * 加载回话和配置选项
	 *
	 * @param   array  $config  配置选项
	 * @return  void
	 */
	public function __construct($config = array())
	{
		// 保存配置信息到对象
		$this->_config = $config;
		$this->_session = Session::instance($this->_config['session_type']);
	}

	abstract protected function _login($username, $password, $remember);

	abstract public function password($username);

	abstract public function check_password($password);

	/**
	 * 获取当前会话的已登陆用户
	 * 如果未登陆，返回NULL
	 *
	 * @param   mixed  $default  用户未登陆时要返回的默认值
	 * @return  mixed
	 */
	public function get_user($default = NULL)
	{
		return $this->_session->get($this->_config['session_key'], $default);
	}

	/**
	 * 登陆用户
	 *
	 * @param   string   $username  用户名
	 * @param   string   $password  密码
	 * @param   boolean  $remember  是否自动登陆
	 * @return  boolean
	 */
	public function login($username, $password, $remember = FALSE)
	{
		return empty($password)
			? FALSE
			: $this->_login($username, $password, $remember);
	}

	/**
	 * 注销当前登陆用户
	 *
	 * @param   boolean  $destroy     完全注销会话
	 * @param   boolean  $logout_all  删除所有用户的token
	 * @return  boolean
	 */
	public function logout($destroy = FALSE, $logout_all = FALSE)
	{
		if ($destroy === TRUE)
		{
			// 注销所有用户会话
			$this->_session->destroy();
		}
		else
		{
			// 删除用户会话
			$this->_session->delete($this->_config['session_key']);
			// 重新生成session_id
			$this->_session->regenerate();
		}

		// 再检查多一次，以防出错
		return ! $this->logged_in();
	}

	/**
	 * 检查用户是否登陆，另外也可以检查是否有指定角色存活
	 *
	 * @param   string  $role  角色名
	 * @return  mixed
	 */
	public function logged_in($role = NULL)
	{
		return ($this->get_user() !== NULL);
	}

	/**
	 * 生成指定文本的密码
	 * 这个方法已经停用，你最好使用[Auth::hash]代替
	 *
	 * @param  string  $password  明文密码
	 */
	public function hash_password($password)
	{
		return $this->hash($password);
	}

	/**
	 * 加密指定字符串
	 *
	 * @param   string  $str  要加密的字符串
	 * @return  string
	 */
	public function hash($str)
	{
		if ( ! $this->_config['hash_key'])
		{
			throw new Auth_Exception('A valid hash key must be set in your auth config.');
		}
		$hash = hash_hmac($this->_config['hash_method'], $str, $this->_config['hash_key']);
		return $hash;
	}

	/**
	 * 完成登录操作，主要是进行会话的处理
	 */
	protected function complete_login($user)
	{
		// 重新生成session_id
		$this->_session->regenerate();
		// 保存用户名到会话
		$this->_session->set($this->_config['session_key'], $user);
		return TRUE;
	}
}

