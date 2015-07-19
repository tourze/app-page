<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 跳转管理
 *
 * @package		Page
 * @category	Controller
 * @copyright	YwiSax
 */
class Controller_Page_Redirect extends Controller_Page_Admin {

	protected $_model_name = 'Page_Redirect';

	/**
	 * 跳转列表
	 */
	public function action_index()
	{
		$redirects = ORM::factory('Page_Redirect')
			->find_all()
			;
		$this->template->title = __('Redirects');
		$this->template->content = View::factory('page/redirect/list', array(
			'redirects' => $redirects,
		));
	}
}

