<?php

namespace page\Controller\Admin;

/**
 * 元素控制器
 *
 * @package page\Controller\Admin
 */
class ElementController extends BaseController
{

    /**
     * 页面元素上移
     */
    public function actionMoveUp()
    {
        $id = (int) $this->request->param('params');
        $block = ORM::factory('Page_Element')
            ->where('id', '=', $id)
            ->find();
        if ( ! $block->loaded())
        {
            throw new Page_Exception('Couldn\'t find block ID :id.', [
                ':id' => $id,
            ]);
        }

        // 查找同页面的下一个块
        $other = ORM::factory('Page_Element')
            ->where('area', '=', $block->area)
            ->where('entry_id', '=', $block->entry->id)
            ->where('order', '<', $block->order)
            ->order_by('order', 'DESC')
            ->find();

        if ($other->loaded())
        {
            // 开始切换相互的位置
            $temp = $block->order;
            $block->order = $other->order;
            $other->order = $temp;
            $block->update();
            $other->update();
        }
        // 跳转回编辑页面
        HTTP::redirect(Route::url('page-admin', [
            'controller' => 'Entry',
            'action'     => 'edit',
            'params'     => $block->entry->id,
        ]));
    }

    /**
     * 页面元素下移
     */
    public function actionMoveDown()
    {
        $id = (int) $this->request->param('params');
        $block = ORM::factory('Page_Element', $id);
        if ( ! $block->loaded())
        {
            throw new Page_Exception('Couldn\'t find block ID :id.', [
                ':id' => $id,
            ]);
        }

        $other = ORM::factory('Page_Element')
            ->where('area', '=', $block->area)
            ->where('entry_id', '=', $block->entry->id)
            ->where('order', '>', $block->order)
            ->order_by('order', 'ASC')
            ->find();

        if ($other->loaded())
        {
            $temp = $block->order;
            $block->order = $other->order;
            $other->order = $temp;
            $block->update();
            $other->update();
        }

        HTTP::redirect(Route::url('page-admin', [
            'controller' => 'Entry',
            'action'     => 'edit',
            'params'     => $block->entry->id,
        ]));
    }

    /**
     * 返回添加元素的页面
     *
     * @param   string   type/page/area 如: 3/89/1
     * @return  void
     */
    public function actionAdd()
    {
        $params = $this->request->param('params');
        $params = explode('/', $params);

        $type = (int) Arr::get($params, 0, null);
        $page = (int) Arr::get($params, 1, null);
        $area = (int) Arr::get($params, 2, null);

        if ( ! $page OR ! $type OR ! $area)
        {
            throw new Page_Exception('Add requires 3 parameters, type, page and area.');
        }
        if ( ! isset(Model_Page_Element::$type_maps[$type]))
        {
            throw new Page_Exception('Element Type ":type" was not found.', [
                ':type' => (int) $type,
            ]);
        }

        $class = Model_Page_Element::factory(Model_Page_Element::$type_maps[$type]);
        $class->request =& $this->request;

        $this->template->title = __('Add Element');
        $this->template->content = $class->actionAdd((int) $page, (int) $area);
        $this->template->content->page = $page;
    }

    /**
     * 返回一个编辑元素的页面
     *
     * @param   int   要编辑的block ID
     * @return  void
     */
    public function actionEdit()
    {
        $id = (int) $this->request->param('params');
        // 加载block
        $block = ORM::factory('Page_Element', $id);
        if ( ! $block->loaded())
        {
            throw new Page_Exception("Couldn't find block ID :id.", [
                ':id' => $id,
            ]);
        }

        $class = Model_Page_Element::factory($block->type_name())
            ->where('id', '=', $block->element)
            ->find();
        if ( ! $class->loaded())
        {
            throw new Page_Exception('":type" with ID ":id" could not be found.', [
                ':type' => $block->type,
                ':id'   => (int) $block->element,
            ]);
        }

        $class->request =& $this->request;
        $class->block =& $block;

        $this->template->title = __('Editing :element', [':element' => __(ucfirst($block->type_name()))]);
        $this->template->content = $class->actionEdit();
        $this->template->content->entry = $block->entry->id;
    }

    /**
     * 删除指定的元素
     */
    public function actionDelete()
    {
        $id = (int) $this->request->param('params');
        $block = ORM::factory('Page_Element', $id);
        if ( ! $block->loaded())
        {
            throw new Page_Exception('Couldn\'t find block ID ":id".', [
                ':id' => $id,
            ]);
        }

        $class = Model_Page_Element::factory($block->type_name())
            ->where('id', '=', $block->element)
            ->find();
        $class->block =& $block;
        $class->request =& $this->request;

        if ( ! $class->loaded())
        {
            throw new Page_Exception('":type" with ID ":id" could not be found.', [
                ':type' => $block->type_name(),
                ':id'   => (int) $block->element,
            ]);
        }

        $this->template->title = __('Delete :element', [':element' => __(ucfirst(Model_Page_Element::$type_maps[$block->type]))]);
        $this->template->content = $class->actionDelete();
    }

    /**
     * 显示所有content类型的元素
     */
    public function actionContent()
    {
        // 分页设置

        $contents = ORM::factory('Page_Element_Content')
            ->order_by('id', 'DESC')
            ->find_all();

        $this->template->title = __(':page');
        $this->template->content = View::factory('page/element/list', [
            'contents' => $contents,
        ]);
    }
}

