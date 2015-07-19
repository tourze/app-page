<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * ORM权限驱动.
 *
 * @package    Kohana/Auth
 * @category   Driver
 */
class Auth_Driver_ORM extends Auth_Driver {

	/**
	 * 检查会话是否有效
	 *
	 * @param   mixed    $role  角色名、角色对象或者包含了角色名的数组
	 * @return  boolean
	 */
	public function logged_in($role = NULL)
	{
		$user = $this->get_user();
		if ( ! $user)
		{
			return FALSE;
		}
		if ($user instanceof Model_Auth_User AND $user->loaded())
		{
			if ( ! $role)
			{
				return TRUE;
			}

			// 下面检查角色
			if (is_array($role))
			{
				$roles = ORM::factory('Auth_Role')
					->where('name', 'IN', $role)
					->find_all()
					->as_array(NULL, 'id')
					;
				if (count($roles) !== count($role))
				{
					return FALSE;
				}
			}
			else
			{
				if ( ! is_object($role))
				{
					$roles = ORM::factory('Auth_Role', array('name' => $role));
					if ( ! $roles->loaded())
					{
						return FALSE;
					}
				}
				else
				{
					$roles = $role;
				}
			}

			return $user->has('roles', $roles);
		}
	}

	/**
	 * 登陆指定用户
	 *
	 * @param   string   $username
	 * @param   string   $password
	 * @param   boolean  $remember  是否自动登陆
	 * @return  boolean
	 */
	protected function _login($user, $password, $remember)
	{
		if ( ! is_object($user))
		{
			$username = $user;
			$user = ORM::factory('Auth_User');
			$user
				->where($user->unique_key($username), '=', $username)
				->find()
				;
		}

		// 加密密码
		if (is_string($password))
		{
			$password = $this->hash($password);
		}

		// If the passwords match, perform a login
		if ($user->has('roles', ORM::factory('Auth_Role', array('name' => 'login'))) AND $user->password === $password)
		{
			if ($remember === TRUE)
			{
				// Token data
				$data = array(
					'user_id'    => $user->pk(),
					'expires'    => time() + $this->_config['lifetime'],
					'user_agent' => sha1(Request::$user_agent),
				);
				// Create a new autologin token
				$token = ORM::factory('Auth_Token')
					->values($data)
					->create();
				// Set the autologin cookie
				Cookie::set('authautologin', $token->token, $this->_config['lifetime']);
			}
			$this->complete_login($user);
			return TRUE;
		}

		// 登陆失败
		return FALSE;
	}

	/**
	 * 无需密码，强制登陆指定用户
	 *
	 * @param   mixed    $user                    username string, or user ORM object
	 * @param   boolean  $mark_session_as_forced  mark the session as forced
	 * @return  boolean
	 */
	public function force_login($user, $mark_session_as_forced = FALSE)
	{
		if ( ! is_object($user))
		{
			$username = $user;
			$user = ORM::factory('Auth_User')
				->where($user->unique_key($username), '=', $username)
				->find()
				;
		}

		if ($mark_session_as_forced === TRUE)
		{
			// Mark the session as forced, to prevent users from changing account information
			$this->_session->set('auth_forced', TRUE);
		}
		// Run the standard completion
		$this->complete_login($user);
	}

	/**
	 * Logs a user in, based on the authautologin cookie.
	 *
	 * @return  mixed
	 */
	public function auto_login()
	{
		if ($token = Cookie::get('authautologin'))
		{
			// Load the token and user
			$token = ORM::factory('Auth_Token', array('token' => $token));

			if ($token->loaded() AND $token->user->loaded())
			{
				if ($token->user_agent === sha1(Request::$user_agent))
				{
					// Save the token to create a new unique token
					$token->save();
					// Set the new token
					Cookie::set('authautologin', $token->token, $token->expires - time());
					// Complete the login with the found data
					$this->complete_login($token->user);
					// Automatic login was successful
					return $token->user;
				}

				// Token is invalid
				$token->delete();
			}
		}

		return FALSE;
	}

	/**
	 * Gets the currently logged in user from the session (with auto_login check).
	 * Returns $default if no user is currently logged in.
	 *
	 * @param   mixed    $default to return in case user isn't logged in
	 * @return  mixed
	 */
	public function get_user($default = NULL)
	{
		$user = parent::get_user($default);

		if ($user === $default)
		{
			// check for "remembered" login
			if (($user = $this->auto_login()) === FALSE)
			{
				return $default;
			}
		}

		return $user;
	}

	/**
	 * Log a user out and remove any autologin cookies.
	 *
	 * @param   boolean  $destroy     completely destroy the session
	 * @param	boolean  $logout_all  remove all tokens for user
	 * @return  boolean
	 */
	public function logout($destroy = FALSE, $logout_all = FALSE)
	{
		// Set by force_login()
		$this->_session->delete('auth_forced');

		if ($token = Cookie::get('authautologin'))
		{
			// Delete the autologin cookie to prevent re-login
			Cookie::delete('authautologin');

			// Clear the autologin token from the database
			$token = ORM::factory('Auth_Token', array('token' => $token));

			if ($token->loaded() AND $logout_all)
			{
				// Delete all user tokens. This isn't the most elegant solution but does the job
				$tokens = ORM::factory('Auth_Token')
					->where('user_id', '=', $token->user_id)
					->find_all()
					;
				
				foreach ($tokens AS $_token)
				{
					$_token->delete();
				}
			}
			elseif ($token->loaded())
			{
				$token->delete();
			}
		}

		return parent::logout($destroy);
	}

	/**
	 * Get the stored password for a username.
	 *
	 * @param   mixed   $user  username string, or user ORM object
	 * @return  string
	 */
	public function password($user)
	{
		if ( ! is_object($user))
		{
			$username = $user;

			// Load the user
			$user = ORM::factory('Auth_User');
			$user
				->where($user->unique_key($username), '=', $username)
				->find()
				;
		}

		return $user->password;
	}

	/**
	 * Complete the login for a user by incrementing the logins and setting
	 * session data: user_id, username, roles.
	 *
	 * @param   object  $user  user ORM object
	 * @return  void
	 */
	protected function complete_login($user)
	{
		$user->complete_login();

		return parent::complete_login($user);
	}

	/**
	 * Compare password with original (hashed). Works for current (logged in) user
	 *
	 * @param   string  $password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		$user = $this->get_user();
		if ( ! $user)
		{
			return FALSE;
		}
		return ($this->hash($password) === $user->password);
	}

} // End Auth ORM

