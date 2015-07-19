<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * CMS实体模型
 */
class Model_CMS_Entry extends Model_CMS {

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	protected $_belongs_to = array(
		'model' => array(
			'model'			=> 'CMS_Model',
			'foreign_key'	=> 'model_id',
		),
	);
	
	protected $_has_many = array(
		'attributes' => array(
			'model'			=> 'CMS_Attribute',
			'foreign_key'	=> 'entry_id',
		),
	);
	
	protected $_load_with = array('model');
	
	public function rules()
	{
		return array(
			'model_id'	=> array(
				array('not_empty'),
			),
		);
	}
	
	public function fields()
	{
		return array(
			'model_id'	=> array(
				array('intval'),
			),
		);
	}
	
	/**
	 * 处理提交过来的数据
	 */
	public function deal_post($model, $post)
	{
		if (is_int($model))
		{
			$model = ORM::factory('CMS_Model', $model);
		}
		
		$this->model_id = $model->id;
		$this->save();
		
		$fields = $model
			->fields
			->find_all()
			;
		foreach ($fields AS $field)
		{
			if (isset($post[$field->name]) AND $post[$field->name])
			{
				$value = is_array($post[$field->name]) ? json_encode($post[$field->name]) : $post[$field->name];
				$attribute = ORM::factory('CMS_Attribute')
					->values(array(
						'entry_id'	=> $this->id,
						'field_id'	=> $field->id,
						'value'		=> $value,
					))
					->save()
					;
			}
		}

		return $this;
	}
}

