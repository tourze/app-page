<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 权限管理-用户字段管理
 */
class Controller_Auth_Field extends Controller_Auth_Admin {

	protected $_model_name = 'Auth_Field';

	/**
	 * 字段列表
	 */
	public function action_list()
	{
		$fields = ORM::factory('Auth_Field')
			->find_all()
			;

		$this->template->content = View::factory('auth/field/list', array(
			'fields'	=> $fields,
		));
	}
	
	/**
	 * 设置为登录可用字段
	 */
	public function action_set_login()
	{
		$this->auto_render = FALSE;
		
		$field = ORM::factory('Auth_Field', $this->request->post('id'));
		
		if ($field->loaded())
		{
			try
			{
				$values = array(
					'login'	=> $this->request->post('value'),
				);
				$field
					->values($values)
					->save()
					;
			}
			catch (ORM_Validataion_Exception $e)
			{
				$this->response->status(500);
				return;
			}
		}
		else
		{
			$this->response->status(500);
		}
	}
}

