<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 布局控制器
 *
 * @package		Page
 * @category	Controller
 * @copyright	YwiSax
 */
class Controller_Page_Layout extends Controller_Page_Admin {

	protected $_model_name = 'Page_Layout';

	/**
	 * 布局列表
	 */
	public function action_index()
	{
		$this->template->title = __('Layouts');
		$this->template->content = View::factory('page/layout/list');
		$this->template->content->layouts = ORM::factory('Page_Layout')
			->order_by('id', 'ASC')
			->find_all();
	}

	/**
	 * 编辑指定的布局
	 */
	public function action_edit()
	{
		$id = (int) $this->request->param('params');
		$layout = ORM::factory('Page_Layout', $id);
		if ( ! $layout->loaded())
		{
			throw new Page_Exception('Could not find layout with id :id.', array(
				':id' => $id,
			));
		}

		$this->template->title = __('Edit Layout');
		$this->template->content = View::factory('page/layout/edit', array(
			'layout'	=> $layout,
			'errors'	=> FALSE,
			'success'	=> FALSE,
		));

		if ($this->request->post())
		{
			try
			{
				$layout
					->values($this->request->post())
					->update();
				$this->template->content->success = __('Updated Successfully');
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->template->content->errors = $e->errors('layout');
			}
			catch (Page_Exception $e)
			{
				$this->template->content->errors = array($e->getMessage());
			}
		}
	}

	/**
	 * 新增一个布局
	 */
	public function action_new()
	{
		$layout = ORM::factory('Page_Layout');

		if ($this->request->post())
		{
			// 保存提交的数据
			try
			{
				$layout->values($this->request->post());
				$layout->save();

				HTTP::redirect(Route::url('page-admin', array('controller' => 'Layout')));
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->template->content->errors = $e->errors('layout');
			}
			catch (Page_Exception $e)
			{
				$this->template->content->errors = array($e->getMessage());
			}
		}

		$this->template->title = __('New Layout');
		$this->template->content = View::factory('page/layout/new', array(
			'layout'    => $layout,
			'errors'    => FALSE,
		));
	}

	/**
	 * 删除指定布局
	 */
	public function action_delete()
	{
		$id = (int) $this->request->param('params');
		// 查找布局
		$layout = ORM::factory('Page_Layout', $id);
		if ( ! $layout->loaded())
		{
			throw new Page_Exception('Could not find layout with id :id.', array(
				':id' => $id,
			));
		}

		$this->template->title = __('Delete Layout');
		$this->template->content = View::factory('page/layout/delete', array(
			'errors' => FALSE,
			'layout' => $layout,
		));

		if ($this->request->post())
		{
			try
			{
				$layout->delete();
				HTTP::redirect(Route::url('page-admin', array('controller' => 'Layout')));
			}
			catch (Exception $e)
			{
				$this->template->content->errors = array(
					'submit' => __('Delete failed! This is most likely caused because this template is still being used by one or more pages.'),
				);
			}
		}
	}
}

