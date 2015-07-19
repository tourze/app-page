<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	'default' => array(
		'driver'       => 'File',
		'hash_method'  => 'sha256',
		'hash_key'     => NULL,
		'lifetime'     => 1209600,
		'session_type' => Session::$default,
		'session_key'  => 'auth_user',
	),
	'file' => array(
		'users' => array(
			// 'admin' => 'b3154acf3a344170077d11bdb5fff31532f679a1919e716a02',
		),
	),
	
	// 角色配置
	'role' => array(
		'autoload'	=> FALSE,
		'resources'	=> array(),
		'roles'		=> array(),
	),

	//'reset_password_time_limit' => 3600,
	'reset_password_time_limit' => 0,
);

