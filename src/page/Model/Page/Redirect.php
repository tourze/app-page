<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 跳转模型
 *
 * @package		Page
 * @category	Model
 * @author     YwiSax
 */
class Model_Page_Redirect extends Model_Page {

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	public static function status()
	{
		return array(
			array(
				'text'	=> __('Permanent'),
				'value'	=> 301,
			),
			array(
				'text'	=> __('Temporary'),
				'value'	=> 302,
			),
		);
	}
	
	public function status_json()
	{
		return json_encode(Model_Page_Redirect::status());
	}

	/**
	 * 过滤规则
	 */
	public function filters()
	{
		return array(
			'url' => array(
				array('trim'),
				array('strip_tags'),
			),
			'newurl' => array(
				array('trim'),
				array('strip_tags'),
			),
		);
	}
	
	/**
	 * 检验规则
	 */
	public function rules()
	{
		return array(
			'url' => array(
				array('not_empty'),
			),
			'newurl' => array(
				array('not_empty'),
			),
			'type' => array(
				array('not_empty'),
			),
		);
	}
	
	/**
	 * 如果查找到，那就直接跳转
	 */
	public function go()
	{
		// 要加载到记录才继续
		if ( $this->loaded())
		{
			if ($this->type == '301' || $this->type == '302')
			{
				Kohana::$log->add('INFO', __("Page - Redirected ':url' to ':newurl' (:type).", array(
					':url' => $this->url,
					':newurl' => $this->newurl,
					':type' => $this->type,
				))); 
				HTTP::redirect($this->newurl, $this->type);
			}
			else
			{
				Kohana::$log->add('ERROR', __("Page - Could not redirect ':url' to ':newurl', type: :type.", array(
					':url' => $this->url,
					':newurl' => $this->newurl,
					':type' => $this->type,
				)));
				throw new Page_Exception('Unknown redirect type', array(), 404);
			}
		}
	}

	/**
	 * 创建记录的同时，插入一份到Log中去
	 */
	public function create(Validation $validation = NULL)
	{
		$result = parent::create($validation);
		if ($this->loaded())
		{
		}
		return $result;
	}
	
	/**
	 * 修改记录的同时，把旧的数据保存到Log中去
	 */
	public function update(Validation $validation = NULL)
	{
		if (empty($this->_changed))
		{
			// 没有东西需要更新
			return $this;
		}

		if ($this->loaded())
		{
		}
		return parent::update($validation);
	}
	
	/**
	 * 删除前保存一份到Log中去
	 */
	public function delete()
	{
		if ($this->loaded())
		{
		}
		return parent::delete();
	}
}

