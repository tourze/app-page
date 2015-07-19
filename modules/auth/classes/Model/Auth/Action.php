<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Auth_Action extends Model_Auth {

	// 自动创建和更新的字段
	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);
	
	protected $_sorting = array(
		'order'	=> 'ASC',
		'id'	=> 'ASC',
	);

	// 关系
	protected $_belongs_to = array(
		'modules' => array(
			'model' => 'Auth_Module',
			'foreign_key' => 'module_id'
		),
	);

	/**
	 * 校验规则
	 */
	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
			),
			'description' => array(
				array('max_length', array(':value', 255)),
			)
		);
	}

	/**
	 * 过滤规则
	 */
	public function filters()
	{
		return array(
			'name'	=> array(
				array('trim'),
				array('strip_tags'),
			),
			'description'	=> array(
				array('trim'),
				array('strip_tags'),
			),
			'order' => array(
				array('intval'),
			),
		);
	}

}

