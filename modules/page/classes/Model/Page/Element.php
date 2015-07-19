<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Element是Page中最重要的概念。所有页面都是基于Element来组成的。
 *
 * @package		Page
 * @category	Model
 * @author		YwiSax
 */
class Model_Page_Element extends Model_Page {

	public static $type_maps = array(
		1	=> 'Content',
		2	=> 'Request',
		3	=> 'Snippet',
	);

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	/**
	 * @var  bool  当前元素是否允许唯一（只允许使用一次）。如果设置为`FALSE`，那么他就跟Snippet作用一样了，可以多处使用。
	 */
	protected $_unique = TRUE;

	/**
	 * @var  object  当前元素所属的block对象，感觉这里可以改进下
	 */
	public $block = NULL;
	
	/**
	 * @var  object  绑定控制器的request到这里
	 */
	public $request = NULL;

	protected $_belongs_to = array(
		'entry' => array(
			'model' => 'Page_Entry',
			'column' => 'entry_id',
		),
	);

	/**
	 * 渲染元素
	 *
	 * @return string
	 */
	protected function _render()
	{
	}
	
	/**
	 * 返回当前模型的自定义标题文本
	 *
	 * @return string
	 */
	public function title()
	{
	}
	
	public function type_name($type = NULL)
	{
		if ($type === NULL)
		{
			$type = $this->type;
		}
		if ( ! isset(Model_Page_Element::$type_maps[$type]))
		{
			throw new Page_Exception('The requested element type ( :type ) not found.', array(
				':type' => $type,
			));
		}
		return Model_Page_Element::$type_maps[$type];
	}

	/**
	 * 添加页面元素
	 *
	 * @param  int  要添加的页面ID
	 * @param  int  要添加的区域位置
	 * @return view
	 */
	public function action_add($page, $area)
	{
		$view = View::factory('page/element/add', array(
			'element' => $this,
			'page' => $page,
			'area' => $area,
		));

		if ($this->request->post())
		{
			try
			{
				$this->values($this->request->post());
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
				$view->errors = $e->errors();
			}
		}
		return $view;
	}

	/**
	 * 编辑指定元素
	 *
	 * @return view
	 */
	public function action_edit()
	{
		$view = View::factory('page/element/edit', array(
			'element' => $this,
		));

		if ($this->request->post())
		{
			try
			{
				$this->values($this->request->post());
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
	 * 删除元素
	 *
	 * @return view
	 */
	public function action_delete()
	{
		$view = View::factory('page/element/delete', array(
			'element' => $this,
		));

		if ($this->request->post())
		{
			if ($this->_unique == TRUE)
			{
				$this->delete();
			}

			$entry = $this->block->entry;
			$this->block->delete();
			HTTP::redirect(Route::url('page-admin', array(
				'controller' => 'Entry',
				'action' => 'edit',
				'params' => $entry->id
			)));
		}
		
		return $view;
	}
	
	/**
	 * 返回当前元素的类型
	 *
	 * @return  string  类型字符串
	 */
	final public function type()
	{
		return str_replace('Model_Page_Element_', '', get_class($this));
	}
	
	const PAGE_ELEMENT_MODEL_PREFIX = 'Model_Page_Element_';
	
	/**
	 * 返回指定类型的模型实例
	 *
	 * @param  string  要创建的元素类型
	 * @return Model_Page_Element object
	 */
	final public static function factory($model, $id = NULL)
	{
		if ($model == 'Type')
		{
			throw new Page_Exception('It seems not like a correct model type.');
		}

		$model = self::PAGE_ELEMENT_MODEL_PREFIX . ucfirst($model);
		$model = new $model;
		if ($id)
		{
			$model->values($id);
		}

		return $model;
	}
	
	/**
	 * 渲染元素
	 *
	 * @return string
	 */
	final public function render()
	{
		$out = '';

		// 确保这个元素已经加载
		if ( ! $this->loaded())
		{
			// 重新加载一次元素
			$this
				->where('id', '=', $this->block->element)
				->find()
				;

			if ( ! $this->loaded())
			{
				if (Kohana::$environment == Kohana::DEVELOPMENT)
				{
				}
				$out = __('Rendering of element failed, element could not be loaded. Block id # :id', array(
					':id' => $this->block->id
				));
				$out .= '<br />';
			}
		}

		// 如果是管理权限，那就渲染控制面板
		if (Page::$adminmode)
		{
			$out .= $this->render_panel();
		}

		// 渲染
		try
		{
			$out .= $this->_render();
		}
		catch (Exception $e)
		{
			if (Kohana::$environment = Kohana::DEVELOPMENT)
			{
				throw $e;
			}
			else
			{
				$out .= __('There was an error while rendering the element: :message', array(
					':message' => $e->getMessage(),
				));
			}
		}
		
		return $out;
	}

	/**
	 * 渲染控制面板
	 *
	 * @return view
	 */
	final public function render_panel()
	{
		if ($this->block == NULL)
		{
			return;
		}

		return View::factory('page/element/panel', array(
			'title' => $this->title(),
			'block' => $this->block,
		)); 
	}

	/**
	 * 创建BLOCK记录
	 *
	 * @param  int  页面ID
	 * @param  int  位置ID
	 * @return view
	 */
	final public function create_block($page, $area)
	{
		if ( ! $this->loaded())
		{
			throw new Page_Exception('Attempting to create a block for an element that does not exist, or has not been created yet.');
		}
		$this->add_one($page, $area, $this->type(), $this->id);
	}
	
	public function add_one($page, $area, $type, $element_id)
	{
		$found_type = FALSE;
		foreach (Model_Page_Element::$type_maps AS $type_id => $type_name)
		{
			if ($type == $type_name)
			{
				$found_type = $type_id;
			}
		}
		if ( ! $found_type)
		{
			throw new Page_Exception('The request element type ( :type ) not found.', array(
				':type' => $type,
			));
		}

		// 查找级别最高的那个
		$element = ORM::factory('Page_Element')
			->where('entry_id', '=', intval($page))
			->where('area', '=', intval($area))
			->order_by('order', 'DESC')
			->find()
			;

		$order = $element->order + 1;

		// 新建
		$values = array(
			'entry_id'	=> $page,
			'area'		=> $area,
			'order'		=> $order,
			'type'		=> $found_type,
			'element'	=> $element_id,
		);

		ORM::factory('Page_Element')
			->values($values)
			->create()
			;
	}
}
