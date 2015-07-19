<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 分页生成类
 *
 * @package    Kohana/Pagination
 * @category   Base
 */
class Kohana_Pagination {

	/**
	 * @var  array  配置信息
	 */
	protected $config = array(
		'current_page'      => array('source' => 'query_string', 'key' => 'page'),
		'total_items'       => 0,
		'items_per_page'    => 10,
		'view'              => 'pagination/basic',
		'auto_hide'         => TRUE,
		'first_page_in_url' => FALSE,
	);

	/**
	 * @var  integer  当前页
	 */
	protected $current_page;

	/**
	 * @var  integer  总条目数
	 */
	protected $total_items;

	/**
	 * @var  integer  每页显示条目
	 */
	protected $items_per_page;

	/**
	 * @var  integer  总页数
	 */
	protected $total_pages;

	/**
	 * @var  integer  Item offset for the first item displayed on the current page
	 */
	protected $current_first_item;

	/**
	 * @var  integer  Item offset for the last item displayed on the current page
	 */
	protected $current_last_item;

	/**
	 * @var  mixed  上一页页码，如果是第一页就设置为FALSE
	 */
	protected $previous_page;

	/**
	 * @var  mixed  下一页页码，如果是最后一页就设置为FALSE
	 */
	protected $next_page;

	/**
	 * @var  mixed  第一页页码。First page number; FALSE if the current page is the first one
	 */
	protected $first_page;

	/**
	 * @var  mixed  最后一页的页码。如果当前页是最后一页，那么为FALSE
	 */
	protected $last_page;

	/**
	 * @var  integer  Query offset
	 */
	protected $offset;

	/**
	 * @var  Request  当前Request对象
	 */
	protected $_request;

	/**
	 * @var  Route  使用到的路由对象
	 */
	protected $_route;

	/**
	 * @var  array  路由参数
	 */
	protected $_route_params = array();

	/**
	 * 创建新的分页实例
	 *
	 * @param   array    $config   分页配置
	 * @param   Request  $request  当前Request
	 * @return  Pagination
	 */
	public static function factory(array $config = array(), Request $request = NULL)
	{
		return new Pagination($config, $request);
	}

	/**
	 * 构造方法
	 *
	 * @param   array    $config   配置
	 * @param   Request  $request  当前Request
	 * @return  void
	 */
	public function __construct(array $config = array(), Request $request = NULL)
	{
		$this->config = $this->config_group() + $this->config;
		if ($request === NULL)
		{
			$request = Request::current();
		}
		$this->_request = $request;
		$this->_route = $request->route();
		$this->_route_params = $request->param();
		$this->setup($config);
	}

	/**
	 * Retrieves a pagination config group from the config file. One config group can
	 * refer to another as its parent, which will be recursively loaded.
	 *
	 * @param   string  $group  Pagination config group; "default" if none given
	 * @return  array   Config group retrieved from the config file
	 */
	public function config_group($group = 'default')
	{
		// 加载分页设置
		$config_file = Kohana::$config->load('pagination');
		$config['group'] = (string) $group;

		while (isset($config['group']) AND isset($config_file->$config['group']))
		{
			$group = $config['group'];
			unset($config['group']);
			$config += $config_file->$group;
		}

		unset($config['group']);
		return $config;
	}

	/**
	 * 加载分页设置，计算分页信息
	 *
	 * @param   array  $config  分页设置
	 * @return  Pagination
	 */
	public function setup(array $config = array())
	{
		if (isset($config['group']))
		{
			$config += $this->config_group($config['group']);
		}
		$this->config = $config + $this->config;

		// Only (re)calculate pagination when needed
		if ($this->current_page === NULL
			OR isset($config['current_page'])
			OR isset($config['total_items'])
			OR isset($config['items_per_page']))
		{
			// Retrieve the current page number
			if ( ! empty($this->config['current_page']['page']))
			{
				// The current page number has been set manually
				$this->current_page = (int) $this->config['current_page']['page'];
			}
			else
			{
				$query_key = $this->config['current_page']['key'];

				switch ($this->config['current_page']['source'])
				{
					case 'query_string':
						$this->current_page = ($this->_request->query($query_key) !== NULL)
							? (int) $this->_request->query($query_key)
							: 1;
						break;
					case 'route':
						$this->current_page = (int) $this->_request->param($query_key, 1);
						break;
				}
			}

			$this->total_items        = (int) max(0, $this->config['total_items']);
			$this->items_per_page     = (int) max(1, $this->config['items_per_page']);
			$this->total_pages        = (int) ceil($this->total_items / $this->items_per_page);
			$this->current_page       = (int) min(max(1, $this->current_page), max(1, $this->total_pages));
			$this->current_first_item = (int) min((($this->current_page - 1) * $this->items_per_page) + 1, $this->total_items);
			$this->current_last_item  = (int) min($this->current_first_item + $this->items_per_page - 1, $this->total_items);
			$this->previous_page      = ($this->current_page > 1) ? $this->current_page - 1 : FALSE;
			$this->next_page          = ($this->current_page < $this->total_pages) ? $this->current_page + 1 : FALSE;
			$this->first_page         = ($this->current_page === 1) ? FALSE : 1;
			$this->last_page          = ($this->current_page >= $this->total_pages) ? FALSE : $this->total_pages;
			$this->offset             = (int) (($this->current_page - 1) * $this->items_per_page);
		}
		return $this;
	}

	const URL_HASH_SEPARATOR = '#';

	/**
	 * 为指定页码生成URL
	 *
	 * @param   integer  $page  页码
	 * @return  string   分页URL
	 */
	public function url($page = 1)
	{
		$page = max(1, (int) $page);
		if ($page === 1 AND ! $this->config['first_page_in_url'])
		{
			$page = NULL;
		}
		switch ($this->config['current_page']['source'])
		{
			case 'query_string':
				return URL::site(
					$this->_request->uri().
					$this->query(array(
						$this->config['current_page']['key'] => $page
					))
				);
			case 'route':
				return URL::site(
					$this->_route->uri(array_merge(
						$this->_route_params, 
						array($this->config['current_page']['key'] => $page)
					)).$this->query()
				);
		}
		return Pagination::URL_HASH_SEPARATOR;
	}

	/**
	 * 检查页码是否存在
	 *
	 * @param   integer  $page  页码
	 * @return  boolean
	 */
	public function valid_page($page)
	{
		if ( ! Valid::digit($page))
		{
			return FALSE;
		}
		return $page > 0 AND $page <= $this->total_pages;
	}

	/**
	 * 渲染分页
	 *
	 * @param   mixed   $view  试图文件名或者视图对象
	 * @return  string  渲染结果
	 */
	public function render($view = NULL)
	{
		if ($this->config['auto_hide'] === TRUE AND $this->total_pages <= 1)
		{
			return '';
		}
		if ($view === NULL)
		{
			$view = $this->config['view'];
		}
		if ( ! $view instanceof View)
		{
			$view = View::factory($view);
		}
		return $view->set(get_object_vars($this))->set('page', $this)->render();
	}

	/**
	 * 获取或者读取请求对象
	 *
	 * @param   Request  $request  请求实例
	 * @return  object   对象实例：分页对象/请求对象
	 */
	public function request(Request $request = NULL)
	{
		if ($request === NULL)
		{
			return $this->_request;
		}
		$this->_request = $request;
		return $this;
	}

	/**
	 * 获取/设置路由对象
	 *
	 * @param   Route   $route  路由对象
	 * @return  object  Route对象/Pagination对象
	 */
	public function route(Route $route = NULL)
	{
		if ($route === NULL)
		{
			return $this->_route;
		}
		$this->_route = $route;
		return $this;
	}

	/**
	 * 获取或者设置分页的路由参数
	 *
	 * @param   array   $route_params  路由参数
	 * @return  array   获取时返回路由参数
	 * @return  object  当前对象
	 */
	public function route_params(array $route_params = NULL)
	{
		if ($route_params === NULL)
		{
			return $this->_route_params;
		}
		$this->_route_params = $route_params;
		return $this;
	}

	/**
	 * 生成分页请求字符串
	 *
	 * @param   array   $params  参数
	 * @return  string  生成的query字符串
	 */
	public function query(array $params = NULL)
	{
		$params = ($params === NULL)
			? $this->_request->query()
			: array_merge($this->_request->query(), $params);
		if (empty($params))
		{
			return '';
		}
		// Note: 如果值为NULL，http_build_query会自动跳过这个字段
		$query = http_build_query($params, '', '&');
		return ($query === '') ? '' : ('?'.$query);
	}

	/**
	 * 渲染分页实例
	 *
	 * @return  string  分页输出，一般为HTML
	 */
	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (Exception $e)
		{
			$error_response = Kohana_Exception::_handler($e);
			return $error_response->body();
		}
	}

	/**
	 * 读取指定属性
	 *
	 * @param   string  $key  属性名
	 * @return  mixed
	 */
	public function __get($key)
	{
		return isset($this->$key) ? $this->$key : NULL;
	}

	/**
	 * 更新字段属性
	 *
	 * @param   string  $key    字段名/配置名
	 * @param   mixed   $value  值
	 * @return  void
	 */
	public function __set($key, $value)
	{
		$this->setup(array($key => $value));
	}
}

