<?php defined('SYSPATH') OR die('No direct script access.');

if ( ! defined('TWIG_PATH'))
{
	define('TWIG_PATH', rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR . 'vendor/twig/lib/');
	Twig::init();
}
