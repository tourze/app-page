<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Page Request Element. Executes a Kohana HMVC request and returns the result.
 *
 * @package		Page
 * @category	Model
 * @copyright	YwiSax
 */
class Model_Page_Element_Request extends Model_Page_Element {

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	/**
	 * 过滤规则
	 */
	public function filters()
	{
		return array(
			'title' => array(
				array('trim'),
				array('strip_tags'),
			),
		);
	}
	
	public function title()
	{
		return __('Request: :url', array(
			':url' => $this->url,
		));
	}
	
	/**
	 * 请求元素中可能会造成循环加载的URL，危险啊
	 */
	protected $recursion_request_url = array(
		'page/view',
		'/page/view',
	);

	/**
	 * 渲染
	 */
	protected function _render()
	{
		// 防止进入死循环
		if (in_array($this->url, $this->recursion_request_url))
		{
			return __('Recursion is bad!');
		}
		
		$out = '';
		try
		{
			$out = Request::factory($this->url)->execute()->body();
		}
		catch (ReflectionException $e)
		{
			$out = __('Request failed. Error: :message', array(
				':message' => $e->getMessage(),
			));
		}
		return $out;
	}
	
	/**
	 * 添加Request请求
	 */
	public function action_add($page, $area)
	{
		$view = View::factory('page/element/request/add', array(
			'element' => $this,
			'errors' => FALSE,
			'page' => $page,
			'area' => $area
		));
		
		if ($_POST)
		{
			try
			{
				$this->values($_POST);
				$this->create();
				$this->create_block($page, $area);
				HTTP::redirect(Route::url('page-admin', array(
					'controller' => 'Entry',
					'action' => 'edit',
					'params' => $page
				)));
			}
			catch (ORM_Validation_Exception $e)
			{
				$view->errors = $e->errors('page');
			}
		}
		return $view;
	}

	/**
	 * 编辑请求信息
	 *
	 * @return view
	 */
	public function action_edit()
	{
		$view = View::factory('page/element/request/edit', array(
			'element' => $this,
		));
		
		if ($_POST)
		{
			try
			{
				$this->values($_POST);
				$this->update();
				$view->success = __('Update successfully');
			}
			catch (ORM_Validation_Exception $e)
			{
				$view->errors = $e->errors('page');
			}
		}

		return $view;
	}

	/**
	 * 创建记录的同时，插入一份到Log中去
	 */
	public function create(Validation $validation = NULL)
	{
		$result = parent::create($validation);
		if ($this->loaded())
		{
		}
		return $result;
	}
	
	/**
	 * 修改记录的同时，把旧的数据保存到Log中去
	 */
	public function update(Validation $validation = NULL)
	{
		if ($this->loaded())
		{
		}
		return parent::update($validation);
	}
	
	/**
	 * 删除前保存一份到Log中去
	 */
	public function delete()
	{
		if ($this->loaded())
		{
		}
		return parent::delete();
	}
}
