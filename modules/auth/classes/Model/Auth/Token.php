<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Auth_Token extends ORM {

	// Relationships
	protected $_belongs_to = array(
		// 每个用户可以有多个角色
		'user' => array(
			'model' => 'Auth_User',
			'through' => 'auth_user_token'
		),
	);
	
	protected $_sorting = array(
		'id'	=> 'ASC',
	);
	
	// 自动创建和更新的字段
	protected $_created_column = array('column' => 'date_created', 'format' => TRUE);
	protected $_updated_column = array('column' => 'date_updated', 'format' => TRUE);

	/**
	 * Handles garbage collection and deleting of expired objects.
	 *
	 * @return  void
	 */
	public function __construct($id = NULL)
	{
		parent::__construct($id);

		if (mt_rand(1, 100) === 1)
		{
			// Do garbage collection
			$this->delete_expired();
		}

		if ($this->expires < time() AND $this->_loaded)
		{
			// This object has expired
			$this->delete();
		}
	}

	/**
	 * Deletes all expired tokens.
	 *
	 * @return  ORM
	 */
	public function delete_expired()
	{
		// Delete all expired tokens
		DB::delete($this->_table_name)
			->where('expires', '<', time())
			->execute($this->_db)
			;
		return $this;
	}

	public function create(Validation $validation = NULL)
	{
		$this->token = $this->create_token();
		return parent::create($validation);
	}

	protected function create_token()
	{
		do
		{
			$token = sha1(uniqid(Text::random('alnum', 32), TRUE));
		}
		while (ORM::factory('Auth_Token', array('token' => $token))->loaded());

		return $token;
	}

} // End User Token Model
