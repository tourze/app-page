<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 权限管理-角色管理
 */
class Controller_Auth_Role extends Controller_Auth_Admin {

	protected $_model_name = 'Auth_Role';

	/**
	 * 角色列表
	 */
	public function action_list()
	{
		$roles = ORM::factory('Auth_Role')
			->find_all()
			;

		$this->template->content = View::factory('auth/role/list', array(
			'roles'	=> $roles,
		));
	}

	/**
	 * 编辑角色
	 */
	public function action_edit()
	{
		// 查找角色
		$role = ORM::factory('Auth_Role', $this->request->param('params'));
		if ( ! $role->loaded())
		{
			throw new Auth_Exception('The requestd role not found.');
		}
		
		$modules = ORM::factory('Auth_Module')->find_all();
		
		$this->template->title = __('Editing :role', array(
			':role'	=> $role->title,
		));
		$this->template->content = View::factory('auth/role/edit', array(
			'role'		=> $role,
			'modules'	=> $modules,
		));
	}
	
	/**
	 * 更新动作权限
	 */
	public function action_update_action()
	{
	}

}

