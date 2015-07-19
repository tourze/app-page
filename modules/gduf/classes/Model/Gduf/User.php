<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 广金首页的用户
 *
 * @package		Kohana/Gduf
 * @category	Model
 * @author     YwiSax
 */
class Model_Gduf_User extends ORM {

	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);

}

