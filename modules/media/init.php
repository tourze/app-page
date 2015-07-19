<?php defined('SYSPATH') OR die('No direct script access.');

Route::set('media', 'media/<filepath>', array(
		'filepath' => '.*',
	))
	->defaults(array(
		'controller' => 'Media',
		'action'     => 'render',
	));

