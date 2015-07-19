<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * CMS字段
 */
class Model_CMS_Field extends Model_CMS {

	protected $_has_many = array(
		'attributes' => array(
			'model'			=> 'CMS_Attribute',
			'foreign_key'	=> 'field_id',
		),
	);

	public static $default_type = 0;

	public static $types = array(
		0	=> array(
			'name'	=> 'input',
			'title'	=> '普通输入',
		),
		1	=> array(
			'name'	=> 'textarea',
			'title'	=> '文本输入',
		),
		4	=> array(
			'name'	=> 'checkbox',
			'title'	=> '多选项目',
		),
		5	=> array(
			'name'	=> 'radio',
			'title'	=> '单选项目',
		),
		6	=> array(
			'name'	=> 'upload',
			'title'	=> '文件上传',
		),
	);

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	protected $_serialize_columns = array('config');

	protected $_sorting = array(
		'order'	=> 'DESC',
		'id'	=> 'DESC',
	);

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
			'description'	=> array(
				array('trim'),
				array('strip_tags'),
			),
		);
	}
	
	public function rules()
	{
		return array(
			'name'	=> array(
				array('not_empty'),
			),
			'title'	=> array(
				array('not_empty'),
			),
		);
	}
	
	public function labels()
	{
		return array(
			'id'			=> __('Field ID'),
			'name'			=> __('Field Name'),
			'title'			=> __('Field Title'),
			'description'	=> __('Field Description'),
			'order'			=> __('Field Order'),
			'type'			=> __('Field Type'),
		);
	}
	
	public function type($type = NULL)
	{
		if ($type === NULL)
		{
			$type = $this->type;
		}
		return isset(Model_CMS_Field::$types[$type])
			? Model_CMS_Field::$types[$type]['name']
			: Model_CMS_Field::$types[0]['name'];
	}

	public function display_input($append = NULL)
	{
		$data = array(
			'front'		=> TRUE,
			'name'		=> $this->name,
			'config'	=> $this->config,
		);
		$data = Arr::merge($data, $append);
		$view_file = 'cms/field/type/' . $this->type();
		return View::factory($view_file, $data);
	}
}

