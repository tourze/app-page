<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 权限管理-动作管理
 */
class Controller_Auth_Action extends Controller_Auth_Admin {

	protected $_model_name = 'Auth_Action';

	/**
	 * 模块列表
	 */
	public function action_list()
	{
		$modules = ORM::factory($this->_model_name)
			->find_all()
			;

		$this->template->content = View::factory('auth/module/list', array(
			'modules'	=> $modules,
		));
	}

	/**
	 * 编辑模块
	 */
	public function action_edit()
	{
		// 查找模块
		$module = ORM::factory('Auth_Module', $this->request->param('params'));
		if ( ! $module->loaded())
		{
			throw new Auth_Exception('The requestd module not found.');
		}
		
		$this->template->title = __('Editing :module', array(
			':module'	=> $module->title,
		));
		$this->template->content = View::factory('auth/module/edit', array(
			'module'	=> $module,
		));
	}
}

