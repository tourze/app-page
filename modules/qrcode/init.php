<?php
/*
 * 二维码生成和解析模块
 */

//require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor/phpqrcode/qrlib.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor/phpqrcode/phpqrcode.php';

Route::set('qrcode-test', 'qrcode.html')
	->defaults(array(
		'controller'	=> 'QRCode',
		'action'		=> 'test',
	));

