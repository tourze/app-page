<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Page控制器基础类
 * 这个控制器主要是进行页面的查找和渲染
 * 如果要了解CMS和控制器的扩展，建议参看下Module目录下的代码
 *
 * @package		Page
 * @category	Controller
 * @copyright	YwiSax
 */
class Controller_Page extends Controller {

	// 空白页面的默认布局
	protected $_layout = 'blank';

	/**
	 * 查看CMS指定页面
	 */ 
	public function action_view()
	{
		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Page', 'Page Controller');
		}

		$url = $this->request->param('path');
		// 去除 Kohana::$base_url
		$url = preg_replace('#^'.Kohana::$base_url.'#', '', $url);
		// 去除结尾的斜杆
		$url = preg_replace('/\/$/', '', $url);
		// 去除开头的斜杆
		$url = preg_replace('/^\//', '', $url);
		// Remove anything ofter a ? or #
		$url = preg_replace('/[\?#].+/', '', $url);

		try
		{
			// 判断和执行跳转
			$this->detect_redirect($url);

			// 查找页面
			$page = ORM::factory('Page_Entry')
				->where('url', '=', $url)
				->where('islink', '=', 0)
				->find()
				;

			if ( ! $page->loaded())
			{
				// 404
				Kohana::$log->add('INFO', "Page - Could not find ':url', IP: :ip, BROWSER: :browser", array(
					':url' => $url,
					':ip' => Request::$client_ip,
					':browser' => strip_tags(Request::$user_agent),
				)); 
				throw new Page_Exception("Could not find '$page->url'", array(), 404);
			}

			// 渲染页面
			$this->response->status(200);
			$out = $page->render();
		}
		catch (Page_Exception $e)
		{
			$out = $this->error($e);
		}

		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}

		if ($page->generate_html)
		{
			Model_Page_Entry::generate_html($url, $out);
		}

		// 最后输出页面啦
		$this->response->body($out);
	}

	/**
	 * 判断和执行跳转操作
	 */
	public function detect_redirect($url)
	{
		//print_r(Kohana::$_paths);
		// 下面这里可能要做个缓存，减少一次查询
		ORM::factory('Page_Redirect')
			->where('url', '=', $url)
			->find()
			->go()
			;
	}

	/**
	 * 返回错误页面
	 */
	public function error($e = NULL)
	{
		if (Kohana::$config->load('page.debug') AND $e !== NULL)
		{
			throw $e;
		}

		$this->response->status(404);
		$error = ORM::factory('Page_Entry')
			->where('url', '=', 'error.html')
			->find()
			;

		// 默认的视图404页面
		if ( ! $error->loaded())
		{
			return View::factory('page/404');
		}
		return $error->render();
	}

	/**
	 * 非CMS页面的渲染助手
	 */
	public function render($data)
	{
		Page::$_page = new stdClass;

		// 标题
		if (isset($data['title']))
		{
			Page::entry('title', $data['title']);
		}

		// 描述
		if (isset($data['metadesc']))
		{
			Page::entry('metadesc', $data['metadesc']);
		}

		// 关键词
		if (isset($data['metakw']))
		{
			Page::entry('metakw', $data['metakw']);
		}

		// 渲染内容
		$this->response->body(
			Page::override(
				$this->_layout,
				(isset($data['content']) ? $data['content'] : '')
			)
		);
	}
}

