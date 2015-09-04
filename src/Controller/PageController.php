<?php

namespace page\Controller;

use page\Exception\PageException;
use tourze\Base\Base;
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

    /**
     * 查看CMS指定页面
     */
    public function actionView()
    {
        $path = $this->request->param('path');
        // 去除 Kohana::$base_url
        $path = preg_replace('#^' . Base::$baseUrl . '#', '', $path);
        // 去除结尾的斜杆
        $path = preg_replace('/\/$/', '', $path);
        // 去除开头的斜杆
        $path = preg_replace('/^\//', '', $path);
        // Remove anything ofter a ? or #
        $path = preg_replace('/[\?#].+/', '', $path);

        try
        {
            $out = $path;
        }
        catch (PageException $e)
        {
            $out = $e->getMessage();
        }

        // 最后输出页面啦
        $this->response->body = $out;
    }

    /**
     * 提交新内容
     */
    public function actionSubmit()
    {
    }
}

