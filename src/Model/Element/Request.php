<?php

namespace page\Model\Element;

use page\Model\Element;
use tourze\Base\Security\Validation;

/**
 * 外部请求内容，返回内容会直接返回
 *
 * @package page\Model\Element
 */
class Request extends Element
{

    protected $_created_column = ['column' => 'date_created', 'format' => true];
    protected $_updated_column = ['column' => 'date_updated', 'format' => true];

    /**
     * 过滤规则
     */
    public function filters()
    {
        return [
            'title' => [
                ['trim'],
                ['strip_tags'],
            ],
        ];
    }

    public function title()
    {
        return __('Request: :url', [
            ':url' => $this->url,
        ]);
    }

    /**
     * 请求元素中可能会造成循环加载的URL，危险啊
     */
    protected $recursion_request_url = [
        'page/view',
        '/page/view',
    ];

    /**
     * 渲染
     */
    protected function _render()
    {
        // 防止进入死循环
        if (in_array($this->url, $this->recursion_request_url))
        {
            return __('Recursion is bad!');
        }

        $out = '';
        try
        {
            $out = Request::factory($this->url)->execute()->body();
        }
        catch (ReflectionException $e)
        {
            $out = __('Request failed. Error: :message', [
                ':message' => $e->getMessage(),
            ]);
        }
        return $out;
    }

    /**
     * 添加Request请求
     */
    public function actionAdd($page, $area)
    {
        $view = View::factory('page/element/request/add', [
            'element' => $this,
            'errors'  => false,
            'page'    => $page,
            'area'    => $area
        ]);

        if ($_POST)
        {
            try
            {
                $this->values($_POST);
                $this->create();
                $this->create_block($page, $area);
                HTTP::redirect(Route::url('page-admin', [
                    'controller' => 'Entry',
                    'action'     => 'edit',
                    'params'     => $page
                ]));
            }
            catch (ORM_Validation_Exception $e)
            {
                $view->errors = $e->errors('page');
            }
        }
        return $view;
    }

    /**
     * 编辑请求信息
     *
     * @return view
     */
    public function actionEdit()
    {
        $view = View::factory('page/element/request/edit', [
            'element' => $this,
        ]);

        if ($_POST)
        {
            try
            {
                $this->values($_POST);
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
     * 创建记录的同时，插入一份到Log中去
     */
    public function create(Validation $validation = null)
    {
        $result = parent::create($validation);
        if ($this->loaded())
        {
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function update(Validation $validation = null)
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
