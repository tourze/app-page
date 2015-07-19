<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 广金相关应用的基础控制器
 *
 * @package		Kohana/Gduf
 * @category	Base
 */
class Controller_Gduf extends Controller_Page {

	public $layout = 'blank';
	
	public function action_index()
	{
		$this->request->response('hello, GDUF!');
	}
}

