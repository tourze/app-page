<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 权限管理-动作管理
 */
class Controller_Auth_Admin extends Controller_Admin {
	
	public function before()
	{
		parent::before();
		Page::style('auth/css/admin.css');
		Page::script('auth/js/admin.js');
	}
}

