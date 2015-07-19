<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 权限-用户模型
 */
class Model_Auth_User extends Model_Auth {

	// 自动创建和更新的字段
	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	/**
	 * 默认排序
	 */
	protected $_sorting = array(
		'id'	=> 'ASC',
	);

	/**
	 * 关系
	 */
	protected $_has_many = array(
		// 每个用户可以有多个角色
		'roles' => array(
			'model' => 'Auth_Role',
			'through' => 'auth_user_role'
		),
		// 每个用户可以有多个数据字段
		'fields' => array(
			'model' => 'Auth_User_Field',
			'foreign_key' => 'user_id',
		),
		// 每个用户可以有多个可用令牌
		'tokens' => array(
			'model' => 'Auth_Token',
			'through' => 'auth_user_token'
		),
	);
	
	// 唯一、不可编辑字段
	protected $_uneditable_columns = array(
		'username', // 用户名不可编辑
		'email', // email不可编辑
	);
	
	protected $_user_field_data = array();
	
	public function values(array $values, array $expected = NULL)
	{
		$parent_return = parent::values($values, $expected);
		foreach ($values AS $k => $v)
		{
			$this->set($k, $v);
		}
		return $parent_return;
	}

	public function set($column, $value)
	{
		$fields = Model_Auth_Field::get_all();
		if (isset($fields[$column]))
		{
			$this->_user_field_data[$column] = $value;
			return $this;
		}
		else
		{
			return parent::set($column, $value);
		}
	}
	
	protected $_user_fields = NULL;
	
	public function user_fields($refresh = FALSE)
	{
		if ($refresh OR $this->_user_fields === NULL)
		{
			$this->_user_fields = ORM::factory('Auth_User_Field')
				->where('user_id', '=', $this->_primary_key_value)
				->find_all()
				->as_array('field_id')
				;
		}
		return $this->_user_fields;
	}
	
	public function get($column)
	{
		// 系统存在的字段
		$fields = Model_Auth_Field::get_all();

		// 会有效率问题
		$user_fields = $this->user_fields();
		if (isset($fields[$column]))
		{
			//print_r($user_fields);
			if (isset($user_fields[$fields[$column]->id]))
			{
				if ($this->id == 4)
				{
					//print_r($user_fields[$fields[$column]->id]);
					//exit;
				}
				return $user_fields[$fields[$column]->id]->value;
			}
			// 返回字段的默认值
			return $fields[$column]->default;
		}
		else
		{
			return parent::get($column);
		}
	}

	public function save(Validation $validation = NULL)
	{
		$parent_result = parent::save($validation);

		// 到这里，肯定已经存在这个记录了
		if ( ! empty($this->_user_field_data))
		{
			// 所有存在的字段
			$fields = Model_Auth_Field::get_all();
			
			// 循环判断现有的字段
			foreach ($this->_user_field_data AS $column => $value)
			{
				if (isset($fields[$column]))
				{
					$relation = ORM::factory('Auth_User_Field')
						->where('user_id', '=', $this->id)
						->where('field_id', '=', $fields[$column]->id)
						->find()
						;
					
					// 更新或新建
					if ( ! $relation->loaded())
					{
						// 判断是否重复
						// 如果要作为登录字段，那就必须唯一
						/*if ($fields[$column]->login)
						{
							$validataion_relation = ORM::factory('Auth_User_Field')
								->where('field_id', '=', $fields[$column]->id)
								->where('value', '=', $value)
								->find()
								;
						}*/
						// 新增
						$relation = ORM::factory('Auth_User_Field')
							->values(array(
								'user_id'	=> $this->id,
								'field_id'	=> $fields[$column]->id,
								'value'		=> $value,
							))
							->save()
							;
					}
					else
					{
						// 更新
						$relation
							->values(array(
								'value'		=> $value,
							))
							->save()
							;
					}
				}
			}
		}

		return $parent_result;
	}
	
	/**
	 * 删除用户的同时，删除用户属性信息
	 */
	public function delete()
	{
		$user_id = $this->id;
		$parent_return = parent::delete();
		
		// 删除用户属性
		$auth_fields = ORM::factory('Auth_User_Field')
			->where('user_id', '=', $user_id)
			->find_all()
			;
		foreach ($auth_fields AS $field)
		{
			$field->delete();
		}

		return $parent_return;
	}
	
	/**
	 * 完成登录步骤，同时更新上次登录时间
	 *
	 * @return void
	 */
	public function complete_login()
	{
		if ($this->_loaded)
		{
			$this->logins		= DB::expr('logins + 1');
			$this->last_login	= time();
			$this->last_ua		= Request::$user_agent;
			$this->update();
		}
	}

	/**
	 * Allows a model use both email and username as unique identifiers for login
	 *
	 * @param   string  unique value
	 * @return  string  field name
	 */
	public function unique_key($value)
	{
		return Valid::email($value) ? 'email' : 'username';
	}

	/**
	 * Password validation for plain passwords.
	 *
	 * @param array $values
	 * @return Validation
	 */
	public static function get_password_validation($values)
	{
		return Validation::factory($values)
			->rule('password', 'min_length', array(':value', 8))
			->rule('password_confirm', 'matches', array(':validation', ':field', 'password'));
	}

	/**
	 * 创建一个新用户
	 *
	 * 简单例子:
	 * ~~~
	 * $user = ORM::factory('Auth_User')->create_user($_POST, array(
	 *	'username',
	 *	'password',
	 *	'email',
	 * );
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 */
	public function create_user($values, $expected)
	{
		// Validation for passwords
		$extra_validation = Model_Auth_User::get_password_validation($values)
			->rule('password', 'not_empty');

		return $this->values($values, $expected)->create($extra_validation);
	}

	/**
	 * 初始化一个用户，通常用于一个用户在注册后，给他分配权限和头像等
	 */
	public function init_user()
	{
		if ( ! $this->loaded())
		{
			throw new Auth_Exception('This method should be called after load the record.');
		}
		// 添加登陆角色权限
		$this->add('roles', ORM::factory('Auth_Role', array('name' => 'login')));
	}

	/**
	 * Update an existing user
	 *
	 * [!!] We make the assumption that if a user does not supply a password, that they do not wish to update their password.
	 *
	 * Example usage:
	 * ~~~
	 * $user = ORM::factory('Auth_User')
	 *	->where('username', '=', 'admin')
	 *	->find()
	 *	->update_user($_POST, array(
	 *		'username',
	 *		'password',
	 *		'email',
	 *	);
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 */
	public function update_user($values, $expected = NULL)
	{
		if (empty($values['password']))
		{
			unset($values['password'], $values['password_confirm']);
		}
		// Validation for passwords
		$extra_validation = Model_Auth_User::get_password_validation($values);

		return $this->values($values, $expected)->update($extra_validation);
	}

	/**
	 * Check user role by role name
	 *
	 * @param  $role_name
	 * @return bool
	 */
	public function has_role($role_name)
	{
		return $this->has('roles', ORM::factory('Auth_Role', array('name' => $role_name)));
	}

}

