<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 社会化论坛入口
 */
class Controller_SocialBBS extends Controller_Page {

	public $layout = 'blank';
	
	public function before()
	{
		parent::before();
	}

	/**
	 * 首页
	 */
	public function action_index()
	{
		$this->render(array(
			'title' => __('Social BBS'),
			'metadesc' => '',
			'metakw' => '',
			'content' => View::factory('socialbbs/index'),
		));
	}
}

