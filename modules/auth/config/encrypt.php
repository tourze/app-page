<?php defined('SYSPATH') OR die('No direct script access.');

return array(

	'default' => array(
		'key'		=> 'asplMtFblDQWSCxvmh2FZsk3wNQbqRVxEAg1QVB34Y9G9TDPXVrweNlmmkZBjct',
		'cipher'	=> MCRYPT_RIJNDAEL_128,
		'mode'		=> MCRYPT_MODE_NOFB,
	),

    'blowfish' => array(
        'key'		=> 'hTTPSz5BSEYrFRZxGT4dL4z08sf4zzVZDko5UPt9YSRUcpV839vYg9DSx7IYekC',
        'cipher'	=> MCRYPT_BLOWFISH,
        'mode'		=> MCRYPT_MODE_ECB,
    ),

    'tripledes' => array(
        'key'		=> 'ATMgjtizJqadxQUrALXZHv5jZC9iJrYVNPU0mIMAdBqSBhEyUbValBEuf6VKYWY',
        'cipher'	=> MCRYPT_3DES,
        'mode'		=> MCRYPT_MODE_CBC,
    ),
);
