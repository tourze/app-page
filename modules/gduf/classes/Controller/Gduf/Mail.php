<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 广金邮箱控制器
 *
 * @package		Kohana/Gduf
 * @category	Mail
 */
class Controller_Gduf_Mail extends Controller_Gduf {

	/**
	 * 校内邮箱部分
	 */
	public function action_index()
	{
		//下面这一句，放在gduf.edu.cn的首页才有用的啊。。。
		//$this->append_meta[] = '<meta http-equiv="Access-Control-Allow-Origin" content="*" />';
		$JSESSIONID = $this->request->cookie('JSESSIONID');

		$this->render(array(
			'title' => '广金邮箱',
			'metadesc' => 'desc',
			'metakw' => 'kw',
			'content' => View::factory('gduf/mail', array(
				'JSESSIONID' => $JSESSIONID,
			)),
		));
	}
	
	/**
	 * 绑定当前广金用户到gdufer去
	 */
	public function action_bind()
	{
		
	}
	
	/**
	 * 退出邮箱登陆
	 */
	public function action_logout()
	{
		// 这里其实还要加多个步骤，就是向远程服务器发送退出登陆的请求
		Cookie::delete('JSESSIONID');
		exit;
	}

	/**
	 * 代理登陆
	 */
	public function action_login()
	{
		$JSESSIONID = Model_Gduf::login($this->request->post('username'), $this->request->post('password'));
		
		// 如果当前已经登陆了，那就直接绑定吧
		if ($JSESSIONID)
		{
			$gduf_user = ORM::factory('Gduf_User')
				->where('username', '=', $this->request->post('username'))
				->where('password', '=', $this->request->post('password'))
				->find()
				;
			if ( ! $gduf_user->loaded())
			{
				$gduf_user = ORM::factory('Gduf_User');
				$gduf_user->username = $this->request->post('username');
				$gduf_user->password = $this->request->post('password');
				$gduf_user->save();
			}
		}
	
		$this->response->body($JSESSIONID);
	}
	
	/**
	 * 代理读取邮件
	 */
	public function action_read()
	{
		$response_data = Model_Gduf_Mail::fetch($this->request->query());
		$this->response->body( $response_data );
	}
	
	/**
	 * 发送邮件
	 */
	public function action_send()
	{
		// 发送POST数据，不发送$_FILES
		$response_data = Model_Gduf_Mail::send($this->request->post());
		$this->response->body(htmlspecialchars($response_data['body']));
	}
	
	/**
	 * 代理邮件列表
	 */
	public function action_list($session = NULL)
	{
		$response = Model_Gduf_Mail::query_data('mail/mail_list.jsp', $this->request->query());

		// 获取返回的状态码，如果不是200那就是错误了
		if ($response['status'] != 200)
		{
			Cookie::delete('JSESSIONID');
			$this->response->body('未登陆，或登陆超时，请刷新本页！');
			return;
		}
		
		$response_body = $response['body'];
		
		$response_data = Model_Gduf_Mail::parse_mail_list($response_body);

		$pagination_config = Kohana::$config->load('pagination.gduf');
		//echo Debug::vars($pagination_config);
		$pagination_config['total_items'] = $response_data['total_page'] * $pagination_config['items_per_page'];
		$this->response->body(View::factory('gduf/mail/box', array(
			'mails' => $response_data,
			'foldertype' => $this->request->query('foldertype'),
			'pagination' => Pagination::factory($pagination_config),
		)));
	}
	
	/**
	 * 移动到垃圾箱
	 */
	public function action_rubbish()
	{
		if ( ! $this->request->post('C_id'))
		{
			return;
		}
		// page=1&foldertype=1&folder=4&C_id=91894867
		$response = Model_Gduf_Mail::post_data('mail/mail_change.jsp?page=1&foldertype=1&folder=4&C_id='.$this->request->post('C_id'), array());
	}
	
	/**
	 * 移动到垃圾箱
	 */
	public function action_delete()
	{
		if ( ! $this->request->post('C_id'))
		{
			return;
		}
		// page=1&foldertype=1&folder=4&C_id=91894867
		$response = Model_Gduf_Mail::post_data('mail/mail_delete.jsp?page=1&foldertype=1&folder=4&C_id='.$this->request->post('C_id'), array());
	}
	
	/**
	 * 获取附件列表
	 */
	public function action_annex_list()
	{
		// 传入的是mail_id
		$annexs = Model_Gduf_Mail::fetch_annex_list($this->request->post('mail_id'));
		if ($annexs)
		{
			$this->response->headers('content-type', 'application/json');
			$this->response->body(json_encode($annexs));
		}
		else
		{
			$this->response->status(500);
		}
	}

}
