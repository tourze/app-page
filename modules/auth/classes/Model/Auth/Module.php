<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 权限-模块模型
 */
class Model_Auth_Module extends Model_Auth {

	// 自动创建和更新的字段
	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);
	
	protected $_sorting = array(
		'order'	=> 'ASC',
		'id'	=> 'ASC',
	);

	// 关系
	protected $_has_many = array(
		'actions' => array(
			'model' => 'Auth_Action',
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
			'order'	=> array(
				array('intval'),
			),
		);
	}
	
	public function list_action_html()
	{
		$actions = $this
			->actions
			->find_all()
			;
		$html = '<ul>';
		foreach ($actions AS $action)
		{
			$html .= "<li><strong>{$action->title}</strong> {$action->name}</li>";
		}
		$html .= '</ul>';
		return $html;
	}

}

