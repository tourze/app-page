<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Page基础类
 *
 * @package    Page
 * @author     YwiSax
 */
class Page {

	const TEMPLATE_VIEW = 'page/xhtml';

	// 当前渲染的页面
	public static $_page = NULL;

	// 是否在管理模式中
	public static $adminmode = FALSE;

	// Content if we are in override
	protected static $_content = NULL;

	// 自定义内容
	protected static $_custom_content = NULL;

	// 处于override模式
	protected static $_override = FALSE;

	// 一些资源文件，乱七八糟的
	protected static $_javascripts = array();
	protected static $_stylesheets = array();
	protected static $_metas = array();

	/**
	 * 返回当前页面。PS：这样写的助手方法是不是不好呢？
	 *
	 * @param  string  页面参数键
	 * @param  mixed   页面参数值
	 */
	public static function entry($key = NULL, $value = NULL)
	{
		// 如果key没有的话，不管那么多，直接返回就是了
		if ($key === NULL)
		{
			return Page::$_page;
		}

		// 页面都没加载，玩毛
		if (Page::$_page === NULL)
		{
			return NULL;
		}

		$key = (string) $key;
		if ($value === NULL)
		{
			return isset(Page::$_page->{$key})
				? Page::$_page->{$key}
				: NULL;
		}
		else
		{
			Page::$_page->{$key} = $value;
		}
	}

	/**
	 * 主系统导航
	 *
	 * @param   string  参数
	 * @return  string  渲染后的导航条
	 */
	public static function main_nav($params = '')
	{
		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Page', __FUNCTION__);
		}
		if ( ! Page::$_override AND ( ! Page::entry('id')))
		{
			return __('Page::main_nav failed because page is not loaded');
		}

		$defaults = array(
			'header' => FALSE,
			'depth' => 1
		);

		$options = array_merge($defaults, Text::params($params));

		if (Page::$_override)
		{
			// 没办法，只能是查找第一个页面然后写咯。
			$descendants = ORM::factory('Page_Entry')
				->where('lvl', '=', 0)
				->find()
				->root()
				->nav_nodes($options['depth']);
		}
		else
		{
			$descendants = Page::entry()
				->root()
				->nav_nodes($options['depth'])
				;
		}

		$out = View::factory('page/navigation', array(
			'nodes' => $descendants,
			'level_column' => 'lvl',
			'options' => $options
		))->render();

		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}
		return $out;
	}

	/**
	 * 二级菜单（侧边栏）菜单
	 *
	 * @param   string   参数字符串
	 * @return  string
	 */
	public static function nav($params = '', $render = TRUE)
	{
		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Page', __FUNCTION__);
		}

		// 确保页面已经加载了。。。
		if ( ! Page::entry('id'))
		{
			return __('Page::secondary_nav failed because page is not loaded');
		}

		$options = Text::params($params);
		// Set the defaults
		$defaults = array(
			// Options for the header before the nav
			'header'       => FALSE,
			'header_elem'  => 'h3',
			'header_class' => '',
			'header_id'    => '',

			// Options for the list itself
			'class'   => '',
			'id'      => '',
			'depth'   => 2,

			// Options for items
			'current_class' => 'current',
			'first_class' => 'first',
			'last_class'  => 'last',
		);
		// Merge to create the options
		$options = Arr::merge($options, $defaults);

		if (Page::entry()->has_children())
		{
			$page = Page::entry();
		}
		else
		{
			$page = Page::entry()
				->parent()
				;
		}

		$descendants = $page->nav_nodes($options['depth']);
		//echo Debug::vars($descendants->as_array());

		if ($render)
		{
			$out = View::factory('page/navigation', array(
				'nodes' => $descendants,
				'level_column'=> 'lvl',
				'options' => $options
			))->render();
		}
		else
		{
			$out = $descendants->as_array();
		}
		
		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}
		
		return $out;
	}


	/**
	 * 渲染面包屑导航
	 *
	 * @return string
	 */
	public static function bread_crumbs()
	{
		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Page', __FUNCTION__);
		}

		if ( ! Page::entry('id'))
		{
			return __('Page::bread_crumbs failed because page is not loaded');
		}

		$parents = Page::entry()
			->parents()
			//->render_descendants('mainnav', TRUE, 'ASC', $maxdepth)
			;

		$out = View::factory('page/breadcrumb')
			->set('nodes', $parents)
			->set('page', Page::entry('name'))
			->render()
			;

		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}
		return $out;
	}

	/**
	 * 渲染站点地图
	 *
	 * @return string
	 */
	public static function site_map()
	{
		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Page', __FUNCTION__);
		}

		if ( ! Page::entry('id'))
		{
			return __('Page::site_map failed because page is not loaded.');
		}

		$out = Page::entry()
			->root()
			->render_descendants('Page.Sitemap', FALSE, 'ASC')
			->render()
			;

		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}
		return $out;
	}

	/**
	 * 渲染和输出元素内容
	 *
	 * @param   int     元素ID
	 * @param   string  元素名称（admin时才有用）
	 * @return  boolean
	 */
	public static function element_area($id, $name)
	{
		if ( ! Page::entry('id'))
		{
			return __('Page Error: element_area(:id) failed. (Page::entry was not set)', array(
				':id' => $id,
			));
		}

		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Page', __FUNCTION__);
		}

		// 自定义页面内容
		if (Page::$_content !== NULL)
		{
			return View::factory('page/element/area', array(
				'id' => $id,
				'name' => $name,
				'content' => Arr::get(Page::$_content, $id-1, '')
			));
		}
		$elements = ORM::factory('Page_Element')
			->where('entry_id', '=', Page::entry('id'))
			->where('area', '=', $id)
			->order_by('order', 'ASC')
			->find_all()
			;
		$content = '';

		foreach ($elements AS $item)
		{
			try
			{
				$element = Model_Page_Element::factory($item->type_name());
				$element->id = $item->element;
				$element->block = $item;
				$content .= $element->render();
			}
			catch (Exception $e)
			{
				if (Kohana::$environment == Kohana::DEVELOPMENT)
				{
					throw $e;
				}
				else
				{
					$content .= __('Error: Could not load element, notice: :message.', array(
						':message' => $e->getMessage(),
					));
				}
			}
		}

		$out = View::factory('page/element/area', array(
			'id' => $id,
			'name' => $name,
			'content' => $content
		))->render();

		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}
		return $out;
	}

	const ELEMENT_CACHE_PREFIX = 'element_cache~';

	/**
	 * 根据指定类型和名称生成元素缓存名
	 */
	public static function generate_element_cache_name($type, $name)
	{
		return Page::ELEMENT_CACHE_PREFIX . $type . '~' . $name;
	}

	/**
	 * 返回指定类型和名称的元素实例
	 *
	 * 如：
	 *  echo element('snippet', 'footer');
	 *
	 * @param  string   元素类型
	 * @param  name     元素名称
	 * @param  lifetime 是否缓存和缓存周期
	 * @return string
	 */
	public static function element($type, $name, $lifetime = NULL)
	{
		// 先尝试从缓存中读取
		$lifetime = (int) $lifetime;
		$key = Page::generate_element_cache_name($type, $name);
		if ($lifetime AND ($cache = Kohana::cache($key, NULL, $lifetime)))
		{
			return $cache;
		}

		$out = '';

		// 读取和解析
		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Page', __FUNCTION__);
		}

		try
		{
			$element = Model_Page_Element::factory($type)
				->where('name', '=', $name)
				->find()
				;
		}
		catch (Exception $e)
		{
			$out .= '<!--';
			$out .= __("Could not render :type ':name' (:message)", array(
				':type' => $type,
				':name' => $name,
				':message' => $e->getMessage(),
			));
			$out .= '-->';
			return $out;
		}

		if ($element->loaded())
		{
			$out = $element->render();
		}
		else
		{
			$out .= '<!--';
			$out .= __("Could not render :type with the name ':name'.", array(
				':type' => $type,
				':name' => $name,
			));
			$out .= '-->';
		}
		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}

		// 保存到缓存
		if ($lifetime)
		{
			Kohana::cache($key, $out, $lifetime);
		}
		return $out;
	}

	/*
	 * CSS控制方法，这个方法可能需要继续优化下
	 */
	public static function style($stylesheet, $media = NULL)
	{
		Page::$_stylesheets[$stylesheet] = $media;
	}

	/**
	 * CSS渲染方法
	 */
	public static function style_render()
	{
		$out = '';
		foreach (Page::$_stylesheets AS $stylesheet => $media)
		{
			if ($media != NULL)
			{
				$out .= "\t" . HTML::style( Media::url($stylesheet), array('media' => $media)) . "\n";
			}
			else
			{
				$out .= "\t" . HTML::style( Media::url($stylesheet) ) . "\n";
			}
		}
		return $out;
	}

	/*
	 * Javascript控制方法，具体用法请参考Layout相关代码
	 *
	 * @param	array	要加载的脚本地址
	 * @return	void
	 */
	public static function script($javascript = NULL)
	{
		// 没参数时直接返回所有地址
		if ($javascript === NULL)
		{
			return Page::$_javascripts;
		}
		// 循环赋值
		if (is_array($javascript))
		{
			foreach ($javascript AS $js)
			{
				Page::script($js);
			}
		}
		else
		{
			// 防止重复引用
			if ( ! in_array($javascript, Page::$_javascripts))
			{
				Page::$_javascripts[] = $javascript;
			}
		}
	}

	/**
	 * 移除指定的脚本链接
	 */
	public static function script_remove($javascript = NULL)
	{
		// 清空全部
		if ($javascript === NULL)
		{
			Page::$_javascripts = array();
		}
		// 如果不是数组，那就转换为数组
		if ( ! is_array($javascript))
		{
			$javascript = array($javascript);
		}
		// 循环删除
		foreach (Page::$_javascripts AS $key => $value)
		{
			if (in_array($value, $javascript))
			{
				unset(Page::$_javascripts[$key]);
			}
		}
	}

	/**
	 * JS渲染器
	 */
	public static function script_render()
	{
		$out = '';
		foreach (Page::$_javascripts AS $key => $javascript)
		{
			$out .= "\t" . HTML::script( Media::url($javascript) ) . "\n";
		}
		return $out;
	}

	/*
	 * META控制方法
	 */
	public static function meta($metas = array())
	{
		if ( ! is_array($metas))
		{
			$metas = array($metas);
		}	
		foreach ($metas AS $key => $meta)
		{
			Page::$_metas[] = $meta;
		}
	}

	/**
	 * META渲染方法
	 */
	public static function meta_render()
	{
		$out = '';
		foreach (Page::$_metas AS $key => $meta)
		{
			$out .= "\t{$meta}\n";
		}
		return $out;
	}

	/**
	 * 返回当前渲染Profile信息
	 *
	 * @return string
	 */
	public static function render_stats()
	{
		$run = Profiler::application();
		$run = $run['current'];
		return __('Page rendered in :time seconds using :memory MB', array(
			':time' => Number::format($run['time'], 3),
			':memory' => Number::format($run['memory'] / 1024 / 1024, 2),
		));
	}

	/**
	 * 使用指定的布局和内容来渲染
	 *
	 * 使用示例：
	 *
	 *     echo Page::override('error', $content);
	 * 
	 * @param  string   要使用的布局名
	 * @param  page     页面内容
	 * @return string
	 * @throws Page_Exception
	 */
	public static function override($layoutname, $content = NULL)
	{
		// 查找对应布局
		$layout = ORM::factory('Page_Layout')
			->where('name', '=', $layoutname)
			->find()
			;
		if ( ! $layout->loaded())
		{
			throw new Page_Exception("Failed to load the layout with name ':layout'.", array(
				':layout' => $layoutname,
			));
		}
		if ($content)
		{
			Page::content($content);
		}
		Page::$_override = TRUE;
		// 设置一些需要的变量，同时渲染页面啦
		return View::factory(Page::TEMPLATE_VIEW, array(
			'layoutcode' => $layout->render($content)
		));
	}

	/**
	 * 指定页面内容
	 *
	 * @param  string  内容，HTML代码等
	 * @return void
	 */
	public static function content($content = NULL)
	{
		if ($content === NULL)
		{
			return Page::$_custom_content;
		}
		Page::$_custom_content = $content;
	}

	/**
	 * Twig渲染的助手方法
	 *
	 * @param  string  要用Twig解析的代码
	 * @return string  Twig解析后的代码
	 */
	public static function twig_render($code)
	{
		static $instance = NULL;

		if (Kohana::$profiling === TRUE)
		{
			// Start a new benchmark
			$benchmark = Profiler::start('Page', 'Twig Render');
		}

		if ($instance === NULL)
		{
			$loader		= new Twig_Loader_String();
			$instance	= Twig::generate_environment($loader);
		}

		$template	= $instance->loadTemplate($code);
		$content	= $template->render(array('Page' => new Page));

		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}
		return $content;
	}
}

