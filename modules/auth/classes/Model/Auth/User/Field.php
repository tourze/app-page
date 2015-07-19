<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 权限-令牌模型
 */
class Model_Auth_User_Field extends Model_Auth {

	// 自动创建和更新的字段
	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	protected $_sorting = array(
		'id'	=> 'ASC',
	);
	
	protected $_load_with = array('user', 'field');

	protected $_belongs_to = array(
		// 每个用户可以有多个角色
		'user' => array(
			'model' => 'Auth_User',
			'foreign_key' => 'user_id',
		),
		'field' => array(
			'model' => 'Auth_Field',
			'foreign_key' => 'field_id',
		),
	);
}

