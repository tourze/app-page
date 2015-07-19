<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * CMS布局模型
 * 在CMS中，模型是跟页面直接相关的部分，因为布局决定页面的总体
 * 你也可以把这里的布局理解为Template（模板）
 *
 * @package		Page
 * @category	Model
 * @author		YwiSax
 */
class Model_Page_Layout extends Model_Page {

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	protected $_has_many = array(
		// 每个布局都可能有多个页面
		'pages' => array(
			'model'=> 'Page_Entry',
			'foreign_key' => 'layout_id',
		),
	);

	/**
	 * 渲染布局内容
	 */
	public function render($content = NULL)
	{
		// 确保布局已经加载完成
		if ( ! $this->loaded())
		{
			return __('Layout Failed to render because it wasn\'t loaded.');
		}

		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Page', 'Render Layout');
		}
		
		$out = Page::twig_render($this->code);
		
		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}

		return $out;
	}
	
	/**
	 * 检验当前Twig模板的有效性
	 */
	public function test_twig()
	{
		// 确保布局代码没有语法错误
		try
		{
			$test = Page::twig_render($this->code);
		}
		catch (Twig_SyntaxError $e)
		{
			$e->setFilename('code');
			throw new Page_Exception('There was a Twig Syntax error: :message', array(
				':message' => $e->getMessage(),
			));
		}
		catch (Exception $e)
		{
			throw new Page_Exception('There was an error: :message on line :line', array(
				':message' => $e->getMessage(),
				':line' => $e->getLine(),
			));
		}
	}

	/**
	 * 重载原来的[create]方法，判断Twig模板有效性等。
	 */
	public function create(Validation $validation = NULL)
	{
		$this->test_twig();

		$result = parent::create($validation);

		if ($this->loaded())
		{
		}
		return $result;
	}

	/**
	 * 重载原来的[update]方法，判断Twig模板有效性等。
	 */
	public function update(Validation $validation = NULL)
	{
		$this->test_twig();
		
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

