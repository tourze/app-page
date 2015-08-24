<?php

namespace page\Controller\Admin;

use page\Controller\AdminController;

/**
 * 跳转管理
 *
 * @package page\Controller\Admin
 */
class RedirectController extends AdminController
{

    protected $_model_name = 'Page_Redirect';

    /**
     * 跳转列表
     */
    public function actionIndex()
    {
        $redirects = ORM::factory('Page_Redirect')
            ->find_all();
        $this->template->title = __('Redirects');
        $this->template->content = View::factory('page/redirect/list', [
            'redirects' => $redirects,
        ]);
    }
}

