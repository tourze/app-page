<?php

namespace page\Controller\Admin;

/**
 * 布局控制器
 *
 * @package page\Controller\Admin
 */
class LayoutController extends BaseController
{

    /**
     * @var string
     */
    protected $_modelName = 'page\Model\Layout';

    /**
     * 布局列表
     */
    public function actionIndex()
    {
        $this->template->title = __('Layouts');
        $this->template->content = View::factory('page/layout/list');
        $this->template->content->layouts = ORM::factory('Page_Layout')
            ->order_by('id', 'ASC')
            ->find_all();
    }

    /**
     * 编辑指定的布局
     */
    public function actionEdit()
    {
        $id = (int) $this->request->param('params');
        $layout = ORM::factory('Page_Layout', $id);
        if ( ! $layout->loaded())
        {
            throw new Page_Exception('Could not find layout with id :id.', [
                ':id' => $id,
            ]);
        }

        $this->template->title = __('Edit Layout');
        $this->template->content = View::factory('page/layout/edit', [
            'layout'  => $layout,
            'errors'  => false,
            'success' => false,
        ]);

        if ($this->request->post())
        {
            try
            {
                $layout
                    ->values($this->request->post())
                    ->update();
                $this->template->content->success = __('Updated Successfully');
            }
            catch (ORM_Validation_Exception $e)
            {
                $this->template->content->errors = $e->errors('layout');
            }
            catch (Page_Exception $e)
            {
                $this->template->content->errors = [$e->getMessage()];
            }
        }
    }

    /**
     * 新增一个布局
     */
    public function actionNew()
    {
        $layout = ORM::factory('Page_Layout');

        if ($this->request->post())
        {
            // 保存提交的数据
            try
            {
                $layout->values($this->request->post());
                $layout->save();

                HTTP::redirect(Route::url('page-admin', ['controller' => 'Layout']));
            }
            catch (ORM_Validation_Exception $e)
            {
                $this->template->content->errors = $e->errors('layout');
            }
            catch (Page_Exception $e)
            {
                $this->template->content->errors = [$e->getMessage()];
            }
        }

        $this->template->title = __('New Layout');
        $this->template->content = View::factory('page/layout/new', [
            'layout' => $layout,
            'errors' => false,
        ]);
    }

    /**
     * 删除指定布局
     */
    public function actionDelete()
    {
        $id = (int) $this->request->param('params');
        // 查找布局
        $layout = ORM::factory('Page_Layout', $id);
        if ( ! $layout->loaded())
        {
            throw new Page_Exception('Could not find layout with id :id.', [
                ':id' => $id,
            ]);
        }

        $this->template->title = __('Delete Layout');
        $this->template->content = View::factory('page/layout/delete', [
            'errors' => false,
            'layout' => $layout,
        ]);

        if ($this->request->post())
        {
            try
            {
                $layout->delete();
                HTTP::redirect(Route::url('page-admin', ['controller' => 'Layout']));
            }
            catch (Exception $e)
            {
                $this->template->content->errors = [
                    'submit' => __('Delete failed! This is most likely caused because this template is still being used by one or more pages.'),
                ];
            }
        }
    }
}
