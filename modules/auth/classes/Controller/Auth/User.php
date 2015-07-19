<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 用户管理控制器
 *
 * @package		Kohana/Auth
 * @category	Controller
 * @copyright	YwiSax
 */
class Controller_Auth_User extends Controller_Auth_Admin {

	protected $_model_name = 'Auth_User';

	/**
	 * 用户首页，也是用户列表
	 */
	public function action_list()
	{
		$page = (int) $this->request->query('page');
		if ($page < 1)
		{
			$page = 1;
		}
		$limit = 30;
		$offset = ($page - 1) * $limit;

		$pagination_config = Kohana::$config->load('pagination.admin_auth_user_list');
		$pagination_config['total_items'] = ORM::factory('Auth_User')
			->find_all()
			->count()
			;
		$pagination_config['items_per_page'] = $limit;

		// 用户列表
		$users = ORM::factory('Auth_User')
			->limit($limit)
			->offset($offset)
			->find_all()
			;
		
		// 字段列表
		$fields = ORM::factory('Auth_Field')
			->find_all()
			;

		$this->template->content = View::factory('auth/user/list', array(
			'users'			=> $users,
			'fields'		=> $fields,
			'pagination'	=> Pagination::factory($pagination_config),
		));
	}

	/**
	 * 编辑用户
	 */
	public function action_edit()
	{
		$id = (int) $this->request->param('params');

		// Find the layout
		$user = ORM::factory('Auth_User', $id);
		if ( ! $user->loaded())
		{
			throw new Page_Exception('Could not find user with id ":id".', array(
				':id' => $id,
			));
		}

		$errors = $success = FALSE;
		
		if ($this->request->post())
		{
			try
			{
				$user->values($this->request->post());
				$user->update();
				$success = __('Updated Successfully');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('user');
			}
		}
		
		$this->template->title = __('Editing User');
		$this->template->content = View::factory('auth/edit', array(
			'user' => $user,
			'errors' => $errors,
			'success' => $success,
		));
	}
}

