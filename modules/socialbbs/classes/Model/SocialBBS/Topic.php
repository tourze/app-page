<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_SocialBBS_Topic extends Model_SocialBBS {

	// 自动创建和更新的字段
	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	// 关系
	protected $_has_many = array(
		'replies' => array(
			'model' => 'SocialBBS_Reply',
			'foreign_key' => 'topic_id'
		),
	);

	/**
	 * 校验规则
	 */
	public function rules()
	{
		return array(
			'title' => array(
				array('not_empty'),
			),
			'content' => array(
				array('not_empty'),
			),
		);
	}

	/**
	 * 过滤规则
	 */
	public function filters()
	{
		return array(
			'title'	=> array(
				array('trim'),
				array('strip_tags'),
			),
			'content'	=> array(
				array('trim'),
				array('strip_tags'),
			),
		);
	}
	
}

