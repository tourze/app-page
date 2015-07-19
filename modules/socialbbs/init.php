<?php
/*
 * 社会化论坛，支持微博/微信/QQ登陆
 */
Route::set('socialbbs-action', 'bbs(/<action>(-<id>)).html', array(
		'action'	=> 'view|list',
		'id'		=> '\d+',
	))
	->defaults(array(
		'controller'	=> 'SocialBBS',
		'action'		=> 'index',
	));

