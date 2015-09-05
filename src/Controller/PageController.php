<?php

namespace page\Controller;

use tourze\Base\Base;
use tourze\Controller\WebController;
use tourze\Http\Http;
use tourze\Http\Request;
use tourze\Twig\Twig;
use Twig_Error_Loader;

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
        // 去除 Base::$baseUrl
        $path = preg_replace('#^' . Base::$baseUrl . '#', '', $path);
        // 去除结尾的斜杆
        $path = preg_replace('/\/$/', '', $path);
        // 去除开头的斜杆
        $path = preg_replace('/^\//', '', $path);
        // 去除?和#之后的所有内容
        $path = preg_replace('/[\?#].+/', '', $path);

        if (empty($path))
        {
            $path = 'index.html';
        }

        try
        {
            $twigPath = $path . '.twig';
            $out = Twig::getTwig()->render($twigPath);
        }
        catch (Twig_Error_Loader $e)
        {
            $out = $e->getMessage();
            $this->response->status = Http::NOT_FOUND;
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
