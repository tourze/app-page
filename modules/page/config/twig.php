<?php defined('SYSPATH') or die('No direct script access.');

return array(

	/**
	 * Twig Loader options
	 */
	'loader' => array(
		'extension' => 'html',  // Extension for Twig files
		'path'      => 'views', // Path within cascading filesystem for Twig files
	),

	/**
	 * Custom functions and filters
	 *
	 *     'functions' => array(
	 *         'my_method' => array('MyClass', 'my_method'),
	 *     ),
	 */
	'functions' => array(
		'url_site'		=> array('URL', 'site'),
		'media_url'		=> array('Media', 'url'),
	),
	'filters' => array(
		// 翻译
		'translate'	=> '__',
		'trans'		=> '__',
		'tr'		=> '__',
		'__'		=> '__',
	),
);
