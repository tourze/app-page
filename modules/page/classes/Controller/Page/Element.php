<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 元素控制器
 *
 * @package		Page
 * @category	Controller
 * @copyright	YwiSax
 */
class Controller_Page_Element extends Controller_Page_Admin {

	/**
	 * 页面元素上移
	 */
	public function action_moveup()
	{
		$id = (int) $this->request->param('params');
		$block = ORM::factory('Page_Element')
			->where('id', '=', $id)
			->find()
			;
		if ( ! $block->loaded())
		{
			throw new Page_Exception('Couldn\'t find block ID :id.', array(
				':id' => $id,
			));
		}

		// 查找同页面的下一个块
		$other = ORM::factory('Page_Element')
			->where('area', '=', $block->area)
			->where('entry_id', '=', $block->entry->id)
			->where('order', '<', $block->order)
			->order_by('order', 'DESC')
			->find()
			;

		if ($other->loaded())
		{
			// 开始切换相互的位置
			$temp = $block->order;
			$block->order = $other->order;
			$other->order = $temp;
			$block->update();
			$other->update();
		}
		// 跳转回编辑页面
		HTTP::redirect(Route::url('page-admin', array(
			'controller' => 'Entry',
			'action' => 'edit',
			'params' => $block->entry->id,
		)));
	}

	/**
	 * 页面元素下移
	 */
	public function action_movedown()
	{
		$id = (int) $this->request->param('params');
		$block = ORM::factory('Page_Element', $id);
		if ( ! $block->loaded())
		{
			throw new Page_Exception('Couldn\'t find block ID :id.', array(
				':id' => $id,
			));
		}

		$other = ORM::factory('Page_Element')
			->where('area', '=', $block->area)
			->where('entry_id', '=', $block->entry->id)
			->where('order', '>', $block->order)
			->order_by('order', 'ASC')
			->find()
			;

		if ($other->loaded())
		{
			$temp = $block->order;
			$block->order = $other->order;
			$other->order = $temp;
			$block->update();
			$other->update();
		}

		HTTP::redirect(Route::url('page-admin', array(
			'controller' => 'Entry',
			'action' => 'edit',
			'params' => $block->entry->id,
		)));
	}

	/**
	 * 返回添加元素的页面
	 *
	 * @param   string   type/page/area 如: 3/89/1
	 * @return  void
	 */
	public function action_add()
	{
		$params = $this->request->param('params');
		$params = explode('/', $params);

		$type = (int) Arr::get($params, 0, NULL);
		$page = (int) Arr::get($params, 1, NULL);
		$area = (int) Arr::get($params, 2, NULL);

		if ( ! $page OR ! $type OR ! $area)
		{
			throw new Page_Exception('Add requires 3 parameters, type, page and area.');
		}
		if ( ! isset(Model_Page_Element::$type_maps[$type]))
		{
			throw new Page_Exception('Element Type ":type" was not found.', array(
				':type'=> (int) $type,
			));
		}

		$class = Model_Page_Element::factory(Model_Page_Element::$type_maps[$type]);
		$class->request =& $this->request;

		$this->template->title = __('Add Element');
		$this->template->content = $class->action_add((int) $page, (int) $area);
		$this->template->content->page = $page;
	}

	/**
	 * 返回一个编辑元素的页面
	 *
	 * @param   int   要编辑的block ID
	 * @return  void
	 */
	public function action_edit()
	{
		$id = (int) $this->request->param('params');
		// 加载block
		$block = ORM::factory('Page_Element', $id);
		if ( ! $block->loaded())
		{
			throw new Page_Exception("Couldn't find block ID :id.", array(
				':id' => $id,
			));
		}

		$class = Model_Page_Element::factory($block->type_name())
			->where('id', '=', $block->element)
			->find()
			;
		if ( ! $class->loaded())
		{
			throw new Page_Exception('":type" with ID ":id" could not be found.', array(
				':type' => $block->type,
				':id' => (int) $block->element,
			));
		}

		$class->request	=& $this->request;
		$class->block	=& $block;

		$this->template->title = __('Editing :element', array(':element' => __(ucfirst($block->type_name()))));
		$this->template->content = $class->action_edit();
		$this->template->content->entry = $block->entry->id;
	}

	/**
	 * 删除指定的元素
	 */
	public function action_delete()
	{
		$id = (int) $this->request->param('params');
		$block = ORM::factory('Page_Element', $id);
		if ( ! $block->loaded())
		{
			throw new Page_Exception('Couldn\'t find block ID ":id".', array(
				':id' => $id,
			));
		}

		$class = Model_Page_Element::factory($block->type_name())
			->where('id', '=', $block->element)
			->find()
			;
		$class->block	=& $block;
		$class->request	=& $this->request;

		if ( ! $class->loaded())
		{
			throw new Page_Exception('":type" with ID ":id" could not be found.', array(
				':type' => $block->type_name(),
				':id' => (int) $block->element,
			));
		}

		$this->template->title = __('Delete :element', array(':element' => __(ucfirst(Model_Page_Element::$type_maps[$block->type]))));
		$this->template->content = $class->action_delete();
	}

	/**
	 * 显示所有content类型的元素
	 */
	public function action_content()
	{
		// 分页设置

		$contents = ORM::factory('Page_Element_Content')
			->order_by('id', 'DESC')
			->find_all()
			;

		$this->template->title = __(':page');
		$this->template->content = View::factory('page/element/list', array(
			'contents'	=> $contents,
		));
	}
}

