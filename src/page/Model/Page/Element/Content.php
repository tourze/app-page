<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Page Content Elemenent. Can render markdown and/or twig.
 *
 * @package		Page
 * @category	Model
 * @copyright	YwiSax
 */
class Model_Page_Element_Content extends Model_Page_Element {

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
			'name' => array(
				array('trim'),
				array('strip_tags'),
			),
			'markdown' => array(
				array('intval'),
			),
			'twig' => array(
				array('intval'),
			),
		);
	}

	public function title()
	{
		return __('Content: :title', array(
			':title' => $this->title,
		));
	}

	protected function _render()
	{
		$out = $this->code;
		
		// Should we run it through markdown?
		if ($this->markdown)
		{
			$out = Markdown($out);
		}
		// Should we run it through twig?
		if ($this->twig)
		{
			$out = Page::twig_render($out);
		}

		return $out;
	}

	/**
	 * 编辑元素内容
	 */
	public function action_edit()
	{
		$view = View::factory('page/element/content/edit', array(
			'element' => $this,
			'errors' => FALSE,
			'success' => FALSE,
		));

		if ($this->request->post())
		{
			$this->values($this->request->post());
			if ($this->twig)
			{
				try
				{
					$test = Page::twig_render($_POST['code']);
				}
				catch (Twig_SyntaxError $e)
				{
					$e->setFilename('code');
					$view->errors[] = __('There was a Twig Syntax error: :message', array(
						':message' => $e->getMessage(),
					));
					return $view;
				}
			}

			// Try saving the element
			try
			{
				$this->update();
				$view->success = __('Updated successfully');
			}
			catch (ORM_Validation_Exception $e)
			{
				$view->errors = $e->errors('page');
			}
		}
		
		return $view;
	}

	/**
	 * 添加页面元素
	 */
	public function action_add($page, $area)
	{
		$view = View::factory('page/element/content/add', array(
			'element' => $this,
			'errors' => FALSE,
			'page' => $page,
			'area' => $area
		));

		if ($this->request->post())
		{
			$this->values($this->request->post());
			
			if ($this->twig)
			{
				try
				{
					$test = Page::twig_render($_POST['code']);
				}
				catch (Twig_SyntaxError $e)
				{
					$e->setFilename('code');
					$view->errors[] = __('There was a Twig Syntax error: :message', array(
						':message' => $e->getMessage(),
					));
					return $view;
				}
			}

			try
			{
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
	 * 重载，修改checkbox的一些选项
	 *
	 * @param  array  数据
	 * @return $this
	 */
	public function values(array $values, array $expected = NULL)
	{
		$values['twig']		= ( ! isset($values['twig'])) ? 0 : 1;
		$values['markdown']	= ( ! isset($values['markdown'])) ? 0 : 1;
		return parent::values($values, $expected);
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

