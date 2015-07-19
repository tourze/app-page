<?php defined('SYSPATH') OR die('No direct script access.');

return array(

	'use_static' => ($_SERVER['HTTP_HOST'] == 'www.luzhongpeng.com' ? TRUE : FALSE),

	// CDN文件替代表，省点流量啊
	'static_file' => array(
	
		// ICON
		'img/logo/144.png'		=> 'http://lzpblog.sinaapp.com/media/img/logo/144.png',
		'img/logo/114.png'		=> 'http://lzpblog.sinaapp.com/media/img/logo/114.png',
		'img/logo/72.png'		=> 'http://lzpblog.sinaapp.com/media/img/logo/72.png',
		'img/logo/57.png'		=> 'http://lzpblog.sinaapp.com/media/img/logo/57.png',
		'img/logo/32.png'		=> 'http://lzpblog.sinaapp.com/media/img/logo/32.png',
		'img/logo/favicon.ico'	=> 'http://lzpblog.sinaapp.com/media/img/logo/favicon.ico',
	
		// bootstrap的css和js文件
		'bootstrap/css/bootstrap.css'					=> 'http://lzpblog.sinaapp.com/media/bootstrap/css/bootstrap.css',
		'bootstrap/css/bootstrap.min.css'				=> 'http://lzpblog.sinaapp.com/media/bootstrap/css/bootstrap.min.css',
		'bootstrap/css/bootstrap-responsive.css'		=> 'http://lzpblog.sinaapp.com/media/bootstrap/css/bootstrap-responsive.css',
		'bootstrap/css/bootstrap-responsive.min.css'	=> 'http://lzpblog.sinaapp.com/media/bootstrap/css/bootstrap-responsive.min.css',
		'bootstrap/js/bootstrap.js'						=> 'http://lzpblog.sinaapp.com/media/bootstrap/js/bootstrap.min.js',
		'bootstrap/js/bootstrap.min.js'					=> 'http://lzpblog.sinaapp.com/media/bootstrap/js/bootstrap.min.js',

		'font-awesome/css/font-awesome.min.css'	=> 'http://lzpblog.sinaapp.com/media/font-awesome/css/font-awesome.min.css',

		'bootbox/bootbox.js'					=> 'http://lzpblog.sinaapp.com/media/bootbox/bootbox.js',

		// bootstrap-wysiwyg
		'bootstrap-wysiwyg/index.css'					=> 'http://lzpblog.sinaapp.com/media/bootstrap-wysiwyg/index.css',
		'bootstrap-wysiwyg/external/jquery.hotkeys.js'	=> 'http://lzpblog.sinaapp.com/media/bootstrap-wysiwyg/external/jquery.hotkeys.js',
		'bootstrap-wysiwyg/bootstrap-wysiwyg.js'		=> 'http://lzpblog.sinaapp.com/media/bootstrap-wysiwyg/bootstrap-wysiwyg.js',

		// jq的插件
		'jquery/jquery.cookie.js'			=> 'http://lzpblog.sinaapp.com/media/jquery/jquery.cookie.js',
		'jquery/jquery.cookie.min.js'		=> 'http://lzpblog.sinaapp.com/media/jquery/jquery.cookie.js',

		// jq
		'jquery/jquery-1.7.2.min.js' => 'http://libs.baidu.com/jquery/1.8.1/jquery.min.js',
		
		'html5shiv.js' => 'http://source1.qq.com/wsd/html5.js',
		
		'uploadify/jquery.uploadify.min.js'	=> 'http://lzpblog.sinaapp.com/media/uploadify/jquery.uploadify.min.js',
		'uploadify/uploadify.css'			=> 'http://lzpblog.sinaapp.com/media/uploadify/uploadify.css',
		
		// weibo
		'weibo/js/script.js'	=> 'http://lzpblog.sinaapp.com/media/weibo/js/script.js',
		'weibo/css/style.css'	=> 'http://lzpblog.sinaapp.com/media/weibo/css/style.css',

		// 程序正式用到的asset
		'css/style.css'				=> 'http://lzpblog.sinaapp.com/media/css/style.css',
		'css/style-responsive.css'	=> 'http://lzpblog.sinaapp.com/media/css/style-responsive.css',
		'js/script.js'				=> 'http://lzpblog.sinaapp.com/media/js/script.js',
		'editor/common.css'			=> 'http://lzpblog.sinaapp.com/media/editor/common.css',
		'editor/common.js'			=> 'http://lzpblog.sinaapp.com/media/editor/common.js',
	),
	
	// 目测gdufcdn稳定一点
	//'cdn_domain' => 'http://gdufcdn.sinaapp.com',
	//'cdn_domain' => 'http://gdufer.qiniudn.com',
);
