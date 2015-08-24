<?php

namespace page\Model\Element;

use page\Model\Element;

/**
 * 内容元素
 *
 * @package page\Model\Element
 */
class Content extends Element
{

    protected $_created_column = ['column' => 'date_created', 'format' => true];
    protected $_updated_column = ['column' => 'date_updated', 'format' => true];

    /**
     * 过滤规则
     */
    public function filters()
    {
        return [
            'title'    => [
                ['trim'],
                ['strip_tags'],
            ],
            'name'     => [
                ['trim'],
                ['strip_tags'],
            ],
            'markdown' => [
                ['intval'],
            ],
            'twig'     => [
                ['intval'],
            ],
        ];
    }

    public function title()
    {
        return __('Content: :title', [
            ':title' => $this->title,
        ]);
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
    public function actionEdit()
    {
        $view = View::factory('page/element/content/edit', [
            'element' => $this,
            'errors'  => false,
            'success' => false,
        ]);

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
                    $view->errors[] = __('There was a Twig Syntax error: :message', [
                        ':message' => $e->getMessage(),
                    ]);
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
    public function actionAdd($page, $area)
    {
        $view = View::factory('page/element/content/add', [
            'element' => $this,
            'errors'  => false,
            'page'    => $page,
            'area'    => $area
        ]);

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
                    $view->errors[] = __('There was a Twig Syntax error: :message', [
                        ':message' => $e->getMessage(),
                    ]);
                    return $view;
                }
            }

            try
            {
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
     * 重载，修改checkbox的一些选项
     *
     * @param  array  数据
     * @return $this
     */
    public function values(array $values, array $expected = null)
    {
        $values['twig'] = ( ! isset($values['twig'])) ? 0 : 1;
        $values['markdown'] = ( ! isset($values['markdown'])) ? 0 : 1;
        return parent::values($values, $expected);
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
     * 修改记录的同时，把旧的数据保存到Log中去
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
