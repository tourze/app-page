<?php

namespace page\Controller;

use Exception;
use page\Exception\PageException;
use page\Model\Page\Entry;
use page\Model\Page\Redirect;
use page\Page;
use stdClass;
use tourze\Base\Base;
use tourze\Base\Config;
use tourze\Base\Log;
use tourze\Controller\WebController;
use tourze\Http\Message;
use tourze\Http\Request;

/**
 * Page控制器基础类
 * 这个控制器主要是进行页面的查找和渲染
 *
 * @package page\Controller
 */
class PageController extends WebController
{

    // 空白页面的默认布局
    protected $_layout = 'blank';

    /**
     * 查看CMS指定页面
     */
    public function actionView()
    {
        $url = $this->request->param('path');
        // 去除 Kohana::$base_url
        $url = preg_replace('#^' . Base::$baseUrl . '#', '', $url);
        // 去除结尾的斜杆
        $url = preg_replace('/\/$/', '', $url);
        // 去除开头的斜杆
        $url = preg_replace('/^\//', '', $url);
        // Remove anything ofter a ? or #
        $url = preg_replace('/[\?#].+/', '', $url);

        try
        {
            // 判断和执行跳转
            (new Redirect([
                'url' => $url
            ]))->go();

            // 查找页面
            $page = new Entry;
            $page->where('url', '=', $url)
                ->where('is_link', '=', 0)
                ->find();

            if ( ! $page->loaded())
            {
                // 404
                Log::info('Base not found.', [
                    'url'     => $url,
                    'ip'      => Request::$clientIp,
                    'browser' => strip_tags(Request::$userAgent),
                ]);
                throw new PageException("Could not find '$page->url'", [], 404);
            }

            // 渲染页面
            $this->response->status = Message::OK;
            $out = $page->render();
        }
        catch (PageException $e)
        {
            $out = $this->error($e);
        }

        // 最后输出页面啦
        $this->response->body = $out;
    }

    /**
     * 返回错误页面
     *
     * @param Exception $e
     * @return mixed
     * @throws Exception
     */
    public function error($e = null)
    {
        if (Config::load('page')->get('debug') && $e !== null)
        {
            throw $e;
        }

        $this->response->status = Message::NOT_FOUND;
        $error = ORM::factory('Page_Entry')
            ->where('url', '=', 'error.html')
            ->find();

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
        $this->response->body = Page::override(
            $this->_layout,
            (isset($data['content']) ? $data['content'] : '')
        );
    }
}

