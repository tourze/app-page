<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * CMS模型
 */
class Model_CMS_Model extends Model_CMS {

	protected $_has_many = array(
		'fields' => array(
			'model'			=> 'CMS_Field',
			'through'		=> 'cms_relation',
			'foreign_key'	=> 'model_id',
			'far_key'		=> 'field_id',
		),
	);

	/**
	 * 默认排序
	 */
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
			'id'			=> __('Model ID'),
			'name'			=> __('Model Name'),
			'title'			=> __('Model Title'),
			'description'	=> __('Model Description'),
			'order'			=> __('Model Order'),
		);
	}

	/**
	 * 处理字段
	 */
	public function deal_fields($request_fields)
	{
		// 系统中存在的所有字段
		$exist_fields = ORM::factory('CMS_Field')
			->find_all()
			->as_array('id')
			;
		$exist_fields_id = array_keys($exist_fields);
		//print_r($exist_fields_id);

		// 请求添加的字段
		$request_fields_id = (array) $request_fields;
		// 交集为有效的集合
		$request_fields_id = array_intersect($request_fields_id, $exist_fields_id);
		//print_r($request_fields_id);

		// 目前模型中有的字段
		$now_fields = $this
			->fields
			->find_all()
			->as_array('id')
			;
		$now_fields_id = array_keys($now_fields);
		// 交集为有效的集合
		$now_fields_id = array_intersect($now_fields_id, $exist_fields_id);
		//print_r($now_fields_id);

		// 不需要更改的字段ID
		$nochange_fields_id = array();
		$nochange_fields_id = array_intersect($request_fields_id, $now_fields_id);
		//print_r($nochange_fields_id);

		// 要新增的字段ID
		$insert_fields_id = array();
		if (count($request_fields_id) > count($nochange_fields_id))
		{
			$insert_fields_id = array_diff($request_fields_id, $nochange_fields_id);
		}
		else
		{
			$insert_fields_id = array_diff($nochange_fields_id, $request_fields_id);
		}
		//print_r($insert_fields_id);
		foreach ($insert_fields_id AS $field_id)
		{
			$this->add('fields', ORM::factory('CMS_Field', $field_id));
		}

		// 要删除的字段ID
		$delete_fileds_id = array();
		if (count($now_fields_id) > count($nochange_fields_id))
		{
			$delete_fileds_id = array_diff($now_fields_id, $nochange_fields_id);
		}
		else
		{
			$delete_fileds_id = array_diff($nochange_fields_id, $now_fields_id);
		}
		//print_r($delete_fileds_id);
		foreach ($delete_fileds_id AS $field_id)
		{
			$this->remove('fields', ORM::factory('CMS_Field', $field_id));
		}

		//exit;
		return $this;
	}

	/**
	 *
	 */
	public function fields_json()
	{
		$fields = $this
			->fields
			->find_all()
			;
		$result = array();
		foreach ($fields AS $field)
		{
			$result[] = $field->id;
		}
		return json_encode($result);
	}
}

