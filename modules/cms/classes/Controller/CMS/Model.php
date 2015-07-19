<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_CMS_Model extends Controller_CMS_Admin {

	public function action_index()
	{
		$models = ORM::factory('CMS_Model')
			->find_all()
			;
		$fields = ORM::factory('CMS_Field')
			->find_all()
			;

		Page::style('cms/css/admin.css');
		Page::script('bootbox/bootbox.js');
		Page::script('cms/js/admin.js');
		$this->template->content = View::factory('page/cms/model/list', array(
			'models'	=> $models,
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

		//print_r($this->request->post());exit;

		if ($this->request->post('id'))
		{
			$model = ORM::factory('CMS_Model')
				->where('id', '=', $this->request->post('id'))
				->find()
				;
			if ( ! $model->loaded())
			{
			}
		}
		else
		{
			$model = ORM::factory('CMS_Model');
		}

		try
		{
			$model
				->values($this->request->post())
				->save()
				->deal_fields($this->request->post('fields'))
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
			$model = ORM::factory('CMS_Model')
				->where('id', '=', $this->request->post('id'))
				->find()
				;
			if ($model->loaded())
			{
				$model->delete();
				return;
			}
		}

		$this->response->status(500);
	}
	
	public function action_column()
	{
		$this->auto_render = FALSE;
		
		$model = ORM::factory('CMS_Model');
		if ($this->request->post('id'))
		{
			$model
				->where('id', '=', $this->request->post('id'))
				->find()
				;
		}
		
		$fields = ORM::factory('CMS_Field')
			->find_all()
			;
		
		$this->response->body(View::factory('page/cms/model/column', array(
			'fields'	=> $fields,
			'model'		=> $model,
		)));
	}
}

