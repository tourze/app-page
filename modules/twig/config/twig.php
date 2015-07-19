<?php defined('SYSPATH') or die('No direct script access.');

return array(

	/**
	 * Twig Loader options
	 */
	'loader' => array(
		'extension' => 'html',  // Extension for Twig files
		'path'      => 'twigs', // Path within cascading filesystem for Twig files
	),

	/**
	 * Twig Environment options
	 *
	 * http://twig.sensiolabs.org/doc/api.html#environment-options
	 */
	'environment' => array(
		'auto_reload'			=> (Kohana::$environment == Kohana::DEVELOPMENT),
		'autoescape'			=> FALSE,
		'base_template_class'	=> 'Twig_Template',
		'cache'					=> (IN_SAE ? 'saekv://twig' : APPPATH.'cache/twig'),
		'charset'				=> 'utf-8',
		'optimizations'			=> -1,
		'strict_variables'		=> FALSE,
	),

	/**
	 * Custom functions and filters
	 *
	 *     'functions' => array(
	 *         'my_method' => array('MyClass', 'my_method'),
	 *     ),
	 */
	'functions' => array(),
	'filters' => array(),

);
