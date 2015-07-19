<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Cloud_Note extends Model_Cloud {

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

}

