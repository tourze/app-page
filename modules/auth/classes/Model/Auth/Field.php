<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 权限-用户字段模型
 */
class Model_Auth_Field extends Model_Auth {

	protected $_sorting = array(
		'order'	=> 'ASC',
		'id'	=> 'ASC',
	);

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);
	
	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
			),
			'title' => array(
				array('not_empty'),
			),
		);
	}

	public function filters()
	{
		return array(
			'name'	=> array(
				array('trim'),
				array('strip_tags'),
			),
			'title'	=> array(
				array('trim'),
				array('strip_tags'),
			),
			'order' => array(
				array('intval'),
			),
			'login' => array(
				array('intval'),
			),
			'description'	=> array(
				array('trim'),
				array('strip_tags'),
			),
		);
	}

	const FILTER_SEPARATOR = ',';

	public function checklist_filters()
	{
		return array(
			array(
				'value'		=> 'trim',
				'text'		=> '过滤两端空格',
			),
			array(
				'value'		=> 'strip_tags',
				'text'		=> '过滤HTML',
			),
			array(
				'value'		=> 'md5',
				'text'		=> 'MD5加密',
			),
			array(
				'value'		=> 'sha1',
				'text'		=> 'SHA1加密',
			),
		);
	}
	
	protected static $_static_fields = NULL;
	
	/**
	 * 获取所有字段信息
	 */
	public static function get_all()
	{
		if (self::$_static_fields === NULL)
		{
			self::$_static_fields = ORM::factory('Auth_Field')
				->find_all()
				->as_array('name')
				;
		}
		return self::$_static_fields;
	}
	
	public function values(array $values, array $expected = NULL)
	{
		if (isset($values['filters']) AND is_array($values['filters']))
		{
			$values['filters'] = implode(Model_Auth_Field::FILTER_SEPARATOR, $values['filters']);
		}
		return parent::values($values, $expected);
	}

	/**
	 * 更新
	 */
	public function update(Validation $validation = NULL)
	{
		if (is_array($this->filters))
		{
			$this->filters = implode(Model_Auth_Field::FILTER_SEPARATOR, $this->filters);
		}
		return parent::update($validation);
	}

}

