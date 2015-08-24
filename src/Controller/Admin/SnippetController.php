<?php

namespace page\Controller\Admin;

/**
 * 内容片断控制器，主要用来保存一些通用的内容块，方便布局调用
 *
 * @package page\Controller\Admin
 */
class SnippetController extends Controller_Page_Admin
{

    protected $_model_name = 'Page_Element_Snippet';

    /**
     * 片段首页，其实就是片段列表
     */
    public function actionIndex()
    {
        $this->template->title = __('Snippets');
        $this->template->content = View::factory('page/snippet/list', [
            'snippets' => Model_Page_Element::factory('Snippet')
                ->order_by('id', 'ASC')
                ->find_all(),
        ]);
    }

    /**
     * 新建片段代码
     */
    public function actionNew()
    {
        $snippet = Model_Page_Element::factory('Snippet');

        $this->template->title = __('Adding Snippet');
        $this->template->content = View::factory('page/snippet/new', [
            'snippet' => $snippet,
            'errors'  => false,
        ]);

        if ($this->request->post())
        {
            $snippet->values($this->request->post());
            // 保存时要确保twig语法无错误啊
            if ($snippet->twig)
            {
                try
                {
                    $test = Page::twig_render($this->request->post('code'));
                }
                catch (Twig_SyntaxError $e)
                {
                    $e->setFilename('code');
                    $this->template->content->errors[] = __('There was a Twig Syntax error: :message', [
                        ':message' => $e->getMessage(),
                    ]);
                    return;
                }
            }

            try
            {
                $snippet->save();
                HTTP::redirect(Route::url('page-admin', ['controller' => 'Snippet']));
            }
            catch (ORM_Validation_Exception $e)
            {
                $this->template->content->errors = $e->errors('snippet');
            }
        }
    }

    /**
     * 编辑片段信息
     */
    public function actionEdit()
    {
        $id = (int) $this->request->param('params');
        // 查找片段
        $snippet = Model_Page_Element::factory('Snippet')
            ->where('id', '=', $id)
            ->find();

        $this->template->title = __('Editing Snippet');
        $this->template->content = View::factory('page/snippet/edit', [
            'snippet' => $snippet,
            'errors'  => false,
            'success' => false,
        ]);

        if ( ! $snippet->loaded())
        {
            throw new Page_Exception('Could not find snippet with id ":id".', [
                ':id' => $id,
            ]);
        }

        if ($this->request->post())
        {

            $snippet->values($this->request->post());

            // Make sure there are no twig syntax errors
            if ($snippet->twig)
            {
                try
                {
                    $test = Page::twig_render($this->request->post('code'));
                }
                catch (Twig_SyntaxError $e)
                {
                    $e->setFilename('code');
                    // 好像有点错误
                    $this->template->content->errors[] = __('There was a Twig Syntax error: :message', [
                        ':message' => $e->getMessage(),
                    ]);
                    return;
                }
            }

            try
            {
                $snippet->update();
                $this->template->content->success = __('Updated Successfully');
            }
            catch (ORM_Validation_Exception $e)
            {
                $this->template->content->errors = $e->errors('snippet');
            }
        }
    }

    /**
     * 删除指定的片段
     */
    public function actionDelete()
    {
        $id = (int) $this->request->param('params');
        // 查找片段信息
        $snippet = Model_Page_Element::factory('Snippet')
            ->where('id', '=', $id)
            ->find();

        if ( ! $snippet->loaded())
        {
            throw new Page_Exception('Could not find snippet with id ":id".', [
                ':id' => $id,
            ]);
        }

        $errors = false;
        if ($this->request->post())
        {
            try
            {
                $snippet->delete();
                HTTP::redirect(Route::url('page-admin', ['controller' => 'Snippet']));
            }
            catch (ORM_Validation_Exception $e)
            {
                $errors = ['submit' => "Delete failed!"];
            }

        }

        $this->template->title = __('Delete Snippet');
        $this->template->content = View::factory('page/snippet/delete', ['snippet' => $snippet]);
        $this->template->content->snippet = $snippet;
        $this->template->content->errors = $errors;
    }
}

