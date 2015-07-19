<?php defined('SYSPATH') OR die('No direct access allowed.');

if ($_SERVER['HTTP_HOST'] == 'test.lzpblog.com')
{
	// 本地调试环境
	$hostname = '127.0.0.1';
	$database = 'test_lzpblog_com';
	$username = 'root';
	$password = 'ywisax';
}
elseif ($_SERVER['HTTP_HOST'] == 'bls.lzpblog.com')
{
	// 本地调试环境
	$hostname = '127.0.0.1';
	$database = 'test_lzpblog_com';
	$username = 'root';
	$password = '';
}
elseif ($_SERVER['HTTP_HOST'] == 'www.luzhongpeng.com')
{
	// VPS
	$hostname = 'localhost';
	$database = 'lzpblog';
	$username = 'lzpblog';
	$password = 'UJXJZKv6qZ4rAWEn';
}
else
{
	$hostname = SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT;
	$database = SAE_MYSQL_DB;
	$username = SAE_MYSQL_USER;
	$password = SAE_MYSQL_PASS;
}

return array
(
	'default' => array
	(
		'type'       => 'MySQLi',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname     server hostname, or socket
			 * string   database     database name
			 * string   username     database username
			 * string   password     database password
			 * boolean  persistent   use persistent connections?
			 * array    variables    system variables as "key => value" pairs
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'hostname'   => $hostname,
			'database'   => $database,
			'username'   => $username,
			'password'   => $password,
			'persistent' => TRUE,
		),
		'table_prefix' => 'lzp_',
		'charset'      => 'utf8',
		'caching'      => '',
		'profiling'    => TRUE,
	),
	
	'hackdb' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname     server hostname, or socket
			 * string   database     database name
			 * string   username     database username
			 * string   password     database password
			 * boolean  persistent   use persistent connections?
			 * array    variables    system variables as "key => value" pairs
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'hostname'   => '127.0.0.1',
			'database'   => 'hackdb',
			'username'   => 'root',
			'password'   => 'yaya',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => '',
		'profiling'    => FALSE,
	),
	
	'alternate' => array(
		'type'       => 'pdo',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn
			 * string   username
			 * string   password
			 * boolean  persistent
			 * string   identifier
			 */
			'dsn'        => 'mysql:host=localhost;dbname=kohana',
			'username'   => 'root',
			'password'   => 'r00tdb',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);

