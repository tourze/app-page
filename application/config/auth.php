<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	// 不用随便更改这个配置啊啊啊啊
	'default' => array(
		'driver'       => 'ORM',
		'hash_method'  => 'sha256',
		'hash_key'     => 'www_gdufer_com_2013',
		'lifetime'     => 1209600,
		'session_type' => Session::$default,
		'session_key'  => 'auth_user',
	),
);

