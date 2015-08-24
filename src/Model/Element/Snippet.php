<?php

namespace page\Model\Element;

use page\Model\Element;

/**
 * 可复用的内容
 *
 * @package page\Model\Element
 */
class Snippet extends Element
{

    protected $_unique = false;

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

    /**
     * 渲染方法的最后实现
     */
    protected function _render()
    {
        $out = $this->code;
        if ($this->markdown)
        {
            $out = Markdown($out);
        }
        if ($this->twig)
        {
            $out = Page::twig_render($out);
        }

        return $out;
    }

    /**
     * 生成一个标题
     */
    public function title()
    {
        return __('Snippet: :snippet', [
            ':snippet' => $this->name
        ]);
    }

    /**
     * 添加一个记录
     */
    public function actionAdd($page, $area)
    {
        $snippets = new Model_Page_Element_Snippet;
        $snippets = $snippets->find_all();
        $view = View::factory('page/element/snippet/add')
            ->bind('element', $this)
            ->set('snippets', $snippets);

        if ($this->request->post())
        {
            try
            {
                $this
                    ->where('id', '=', (int) $this->request->post('element'))
                    ->find();

                if ( ! $this->loaded())
                {
                    throw new Page_Exception('Attempting to add an element that does not exist. Id: {$this->id}');
                }

                $this->create_block($page, $area);
                HTTP::redirect(Route::url('page-admin', [
                    'controller' => 'Entry',
                    'action'     => 'edit',
                    'params'     => $page,
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
     * 编辑元素
     */
    public function actionEdit()
    {
        $snippets = new Model_Page_Element_Snippet;
        $snippets = $snippets
            ->find_all()
            ->as_array('id');
        $view = View::factory('page/element/snippet/edit')
            ->bind('element', $this)
            ->set('snippets', $snippets);

        if ($this->request->post())
        {
            try
            {
                $element_id = (int) $this->request->post('element');
                if ( ! isset($snippets[$element_id]))
                {
                    return false;
                }
                $this->block->element = $element_id;
                $this->block->save();
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
     * 重载
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
        // 保存一份到Element.Snippet.Log中去
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
        // 保存一份到Element.Snippet.Log中去
        if ($this->loaded())
        {
        }
        return parent::delete();
    }
}

