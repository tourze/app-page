<?php

namespace page\Controller\Admin;

use page\Page;
use tourze\Base\Config;
use tourze\Controller\TemplateController;
use tourze\Http\Message;
use tourze\Model\Exception\ValidationException;
use tourze\Model\Model;
use tourze\View\View;

/**
 * 后台基础控制器
 *
 * @package page\Controller\Admin
 */
class BaseController extends TemplateController
{

    protected $_modelName = '';

    /**
     * @var  View  后台的模板视图
     */
    public $template = 'admin';

    /**
     * @var  bool  是否自动加载模板
     */
    public $auto_render = true;

    /**
     * 后台的前置操作，主要是进行用户的检验等等
     */
    public function before()
    {
        parent::before();

        // 使用基础认证
        $users = Config::load('admin')->get('users');
        if (
            is_array($users)
            && isset($_SERVER['PHP_AUTH_USER'])
            && isset($users[$_SERVER['PHP_AUTH_USER']])
            && ($_SERVER['PHP_AUTH_PW'] == $users[$_SERVER['PHP_AUTH_USER']])
        )
        {
            // go on
        }
        else
        {
            header('WWW-Authenticate: Basic realm="Login"');
            header('HTTP/1.1 401 Unauthorized');
            exit('FAILED');
        }

        // 最基础的jq库
        Page::script('jquery/jquery-1.7.2.min.js');

        // bootstrap
        Page::style('bootstrap/css/bootstrap.min.css');
        Page::style('bootstrap/css/bootstrap-responsive.min.css');
        Page::script('bootstrap/js/bootstrap.min.js');

        // 图标
        Page::style('font-awesome/css/font-awesome.min.css');

        // editable
        Page::style('bootstrap-editable/css/bootstrap-editable.css');
        Page::script('bootstrap-editable/js/bootstrap-editable.js');

        // bootbox
        Page::script('bootbox/bootbox.js');

        // 后台自定义
        Page::style('admin/css/admin.css');
        Page::script('admin/js/admin.js');
    }

    /**
     * 更新信息
     */
    public function actionUpdate()
    {
        $this->autoRender = false;
        if ( ! $this->_modelName)
        {
            $this->response->status = Message::INTERNAL_SERVER_ERROR;
            return;
        }

        /** @var Model $item */
        $item = new $this->_modelName;
        $item->where('id', '=', $this->request->post('pk'))->find();
        // 记录不存在
        if ( ! $item->loaded())
        {
            $this->response->status = Message::INTERNAL_SERVER_ERROR;
            return;
        }

        try
        {
            $data = [
                $this->request->post('name') => $this->request->post('value'),
            ];
            $item
                ->values($data)
                ->save();
        }
        catch (ValidationException $e)
        {
            $this->response->status = Message::INTERNAL_SERVER_ERROR;
            return;
        }
    }

    /**
     * 新增记录
     */
    public function actionNew()
    {
        $this->autoRender = false;
        $this->response->headers('content-type', 'application/json');

        /** @var Model $item */
        $item = new $this->_modelName;

        $result = [];
        try
        {
            $item
                ->values($this->request->post())
                ->save();
            $result['id'] = $item->id;
        }
        catch (ValidationException $e)
        {
            //$this->response->status(500);
            $result['errors'] = $e->errors();
            //return;
        }
        $this->response->body = json_encode($result);
    }

    /**
     * 删除模块
     */
    public function actionDelete()
    {
        $this->autoRender = false;

        // 查找字段
        /** @var Model $item */
        $item = new $this->_modelName;
        $item->where('id', '=', $this->request->post('id'))
            ->find();
        if ( ! $item->loaded())
        {
            $this->response->status = Message::INTERNAL_SERVER_ERROR;
            return;
        }

        try
        {
            $item->delete();
        }
        catch (ValidationException $e)
        {
            $this->response->status = Message::INTERNAL_SERVER_ERROR;
            return;
        }
    }

    public function after()
    {
        // 如果有必要的话，这里可以加一些操作记录下每一步
        parent::after();
    }
}

