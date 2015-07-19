<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * CMS实体属性
 */
class Model_CMS_Attribute extends Model_CMS {

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	protected $_belongs_to = array(
		'entry' => array(
			'model'			=> 'CMS_Entry',
			'foreign_key'	=> 'entry_id',
		),
		'field' => array(
			'model'			=> 'CMS_Field',
			'foreign_key'	=> 'field_id',
		),
	);
	
	protected $_load_with = array('entry', 'field');
	
	public function rules()
	{
		return array(
			'entry_id'	=> array(
				array('not_empty'),
			),
			'field_id'	=> array(
				array('not_empty'),
			),
		);
	}
	
	public function filters()
	{
		return array(
			'entry_id'	=> array(
				array('intval'),
			),
			'field_id'	=> array(
				array('intval'),
			),
		);
	}
}

