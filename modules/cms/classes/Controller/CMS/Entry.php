<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 实体管理
 */
class Controller_CMS_Entry extends Controller_CMS_Admin {

	public function action_index()
	{
		$models = ORM::factory('CMS_Model')
			->find_all()
			;

		Page::style('cms/css/admin.css');
		Page::script('bootbox/bootbox.js');
		Page::script('cms/js/admin.js');
		$this->template->content = View::factory('page/cms/entry/list', array(
			'models'	=> $models,
		));
	}

	/**
	 * 添加指定模型的实体
	 */
	public function action_add()
	{
		$model = ORM::factory('CMS_Model', $this->request->param('params'));
		if ( ! $model->loaded())
		{
			throw new CMS_Exception('The requested model not found.');
		}

		// model列表
		$models = ORM::factory('CMS_Model')
			->find_all()
			;

		$entry = ORM::factory('CMS_Entry');
		$errors = array();

		if ($this->request->post())
		{
			try
			{
				$entry
					->deal_post($model, $this->request->post())
					;
				HTTP::redirect(Route::url('cms-admin', array(
					'controller'	=> 'Entry',
					'action'		=> 'edit',
					'params'		=> $entry->id,
				)));
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors();
			}
		}

		$this->template->content = View::factory('page/cms/entry/edit', array(
			'current_model'		=> $model,
			'models'			=> $models,
			'entry'				=> $entry,
		));
	}
	
	/**
	 * 编辑指定实体
	 */
	public function action_edit()
	{
		// model列表
		$models = ORM::factory('CMS_Model')
			->find_all()
			;

		$entry = ORM::factory('CMS_Entry', $this->request->param('params'));
		if ( ! $entry->loaded())
		{
			throw new CMS_Exception('The requested entry not found.');
		}
		$errors = array();

		if ($this->request->post())
		{
			try
			{
				$entry
					->deal_post($model, $this->request->post())
					;
				exit;
				HTTP::redirect(Route::url('cms-admin', array(
					'controller'	=> 'Entry',
					'action'		=> 'edit',
					'id'			=> $entry->id,
				)));
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors();
			}
		}

		$this->template->content = View::factory('page/cms/entry/edit', array(
			'current_model'		=> $entry->model,
			'models'			=> $models,
			'entry'				=> $entry,
		));
	}
}

