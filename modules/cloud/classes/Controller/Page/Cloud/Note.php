<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 云笔记
 *
 * 有一个问题，因为笔记是加密存放的，那么，无法分析关键词，这个比较麻烦。
 * 可能需要用户认真编辑标题
 */
class Controller_Page_Cloud_Note extends Controller_Page_Cloud {

	/**
	 * 笔记默认页面
	 */
	public function action_index()
	{
		Page::script('cloud/js/gibberish-aes-1.0.0.js');
		Page::script('bootbox/bootbox.js');

		Page::style('bootstrap-wysiwyg/index.css');
		Page::style('editor/common.css');
		Page::script('bootstrap-wysiwyg/external/jquery.hotkeys.js');
		Page::script('bootstrap-wysiwyg/bootstrap-wysiwyg.js');
		Page::script('editor/common.js');

		Page::style('cloud/css/note.css');

		Page::script('cloud/js/note.js');
		$this->template->content = View::factory('page/cloud/note/index');
	}

	/**
	 * 返回笔记列表（仅标题），JSON格式
	 */
	public function action_list()
	{
		$notes = ORM::factory('Cloud_Note')
			->order_by('id', 'DESC')
			->find_all()
			;
		$result = array();
		$html = '';
		foreach ($notes AS $note)
		{
			$result[] = array(
				'id'	=> $note->id,
				'title' => $note->title,
			);
			$html .= '<li id="cloud-note-'.$note->id.'"><a data-id="'.$note->id.'" href="javascript:void(0)" onclick="GetCloudNote('.$note->id.');return false;" title="'.$note->title.'">'.$note->title.'</a></li>';
		}
		$this->auto_render = FALSE;
		//$this->response->headers('content-type', 'application/json');
		//$this->response->body(json_encode($result));
		$this->response->body($html);
	}

	/**
	 * 读取指定的笔记信息
	 */
	public function action_get()
	{
		$this->auto_render = FALSE;

		$note = ORM::factory('Cloud_Note')
			->where('id', '=', $this->request->post('id'))
			->find()
			;
		if ( ! $note->loaded())
		{
			$this->response->status(500);
			return;
		}
		$this->response->headers('content-type', 'application/json');
		$this->response->body(json_encode(array(
			'id'	=> $note->id,
			'title' => $note->title,
			'content' => $note->content,
		)));
	}

	/**
	 * 添加/编辑笔记
	 */
	public function action_edit()
	{
		$this->auto_render = FALSE;
		$this->response->headers('content-type', 'application/json');
		if ($this->request->post())
		{
			$note = ORM::factory('Cloud_Note');
			if ($this->request->post('id'))
			{
				$note
					->where('id', '=', $this->request->post('id'))
					->find()
					;
				if ( ! $note->loaded())
				{
					$this->response->body(json_encode(array(
						'error' => 1,
						'text'  => '指定的笔记不存在。',
					)));
					return;
				}
			}


			try
			{
				$note
					->values($this->request->post())
					->save()
					;
			}
			catch (ORM_Validation_Exception $e)
			{
				$this->response->body(json_encode(array(
					'error' => 1,
					'text'  => Debug::vars($e->errors()),
				)));
				return;
			}

			$this->response->body(json_encode(array(
				'error' => 0,
				'title' => $note->title,
				'id'	=> $note->id,
			)));
		}
	}

	/**
	 * 删除笔记
	 */
	public function action_delete()
	{
		$this->auto_render = FALSE;
		$note = ORM::factory('Cloud_Note')
			->where('id', '=', $this->request->post('id'))
			->find()
			;
		if ( ! $note->loaded())
		{
			$this->response->status(500);
			return;
		}

		$note->delete();
	}
}

