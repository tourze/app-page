<?php defined('SYSPATH') OR die('No direct script access.');

// http://www.gduf.edu.cn/mail/personnel.jsp?addr4=&addr3=&addr2=&copy2=&secret2=&addrdep2=&copydep2=&secretdep2=

defined('GDUF_DOMAIN') OR define('GDUF_DOMAIN', 'http://www.gduf.edu.cn/');

// 下面添加路由

// 广金邮箱
Route::set('gduf-mail', 'gduf/mail.html')
	->defaults(array(
		'directory' => 'Gduf',
		'controller' => 'Mail',
		'action' => 'index',
	));
Route::set('gduf-mail-action', 'gduf/mail-<action>.html', array(
		'action' => 'login|list|logout|delete|rubbish|send|read|bind|annex_list|people_search',
	))
	->defaults(array(
		'directory' => 'Gduf',
		'controller' => 'Mail',
	));
// 教务处
Route::set('gduf-jwc', 'gduf/jwc.html')
	->defaults(array(
		'directory' => 'Gduf',
		'controller' => 'JWC',
		'action' => 'index',
	));
Route::set('gduf-jwc-action', 'gduf/jwc-<action>.html', array(
		'action' => 'login|fetch|analysis',
	))
	->defaults(array(
		'directory' => 'Gduf',
		'controller' => 'JWC',
	));
