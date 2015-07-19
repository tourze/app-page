<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 字段管理
 */
class Controller_CMS_Field extends Controller_CMS_Admin {

	public function action_index()
	{
		$fields = ORM::factory('CMS_Field')
			->find_all()
			;

		Page::style('cms/css/admin.css');
		Page::script('bootbox/bootbox.js');
		Page::script('cms/js/admin.js');
		$this->template->content = View::factory('page/cms/field/list', array(
			'fields'	=> $fields,
		));
	}
	
	/**
	 * 更新/新增
	 */
	public function action_update()
	{
		$this->auto_render = FALSE;
		if ( ! $this->request->post())
		{
			exit;
		}
		
		if ($this->request->post('id'))
		{
			$field = ORM::factory('CMS_Field')
				->where('id', '=', $this->request->post('id'))
				->find()
				;
			if ( ! $field->loaded())
			{
			}
		}
		else
		{
			$field = ORM::factory('CMS_Field');
		}
		
		try
		{
			$type = $this->request->post('type');
			
			if (isset($_POST['config'][$type]))
			{
				// 还要考虑过滤问题
				$this->request->post('config', $_POST['config'][$type]);
			}
			else
			{
				$this->request->post('config', NULL);
			}
			
			$field
				->values($this->request->post())
				->save()
				;
		}
		catch (ORM_Validation_Exception $e)
		{
			echo Debug::vars($e->errors());
			exit;
		}
		HTTP::redirect( $this->request->referrer() );
	}
	
	/**
	 * 删除字段
	 */
	public function action_delete()
	{
		$this->auto_render = FALSE;
		if ($this->request->post())
		{
			$field = ORM::factory('CMS_Field')
				->where('id', '=', $this->request->post('id'))
				->find()
				;
			if ($field->loaded())
			{
				$field->delete();
				return;
			}
		}

		$this->response->status(500);
	}
}

