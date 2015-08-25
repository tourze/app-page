<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<title><?php echo Page::entry('title') ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1">	
	<meta name="description" content="<?php echo Page::entry('metadesc') ?>" />
	<meta name="keywords" content="<?php echo Page::entry('metakw') ?>" />
	<!--[if lt IE 9]><script src="<?php echo Media::url('html5shiv.js') ?>"></script><![endif]-->
	<!-- HEAD文件包含-begin -->
	<?php echo Page::style_render(); ?>
	<?php echo Page::meta_render(); ?>
	<!-- HEAD文件包含-end -->
	<link rel="icon" href="<?php echo Media::url('img/logo/favicon.ico') ?>" mce_href="<?php echo Media::url('img/logo/favicon.ico') ?>" type="image/x-icon">
	<link rel="shortcut icon" href="<?php echo Media::url('img/logo/favicon.ico') ?>" mce_href="<?php echo Media::url('img/logo/favicon.ico') ?>" type="image/x-icon">
</head>
<body
	<?php if (Page::$adminMode) { echo ' id="page-admin"'; } ?>
>
	<?php if (Page::$adminMode): ?>
	<!-- Admin mode header -->
	<div id="page-header">
		<p>
			<?php echo HTML::anchor(Route::url('page-admin', array('controller' => 'Entry')), '&laquo; '.__('Back')) ?> | 
			<?php echo __('You are editing :page', array(':page' => '<strong>'.Page::entry('name').'</strong>')) ?> |
			<?php echo HTML::anchor(Route::url('page-admin', array(
				'controller' => 'Entry',
				'action' => 'meta',
				'params' => Page::entry('id'),
			)),__('Edit meta data')) ?>
		</p>
	</div>
	<!-- End Admin mode header -->
	<?php endif; ?>
	<!-- Begin Page Layout Code -->
	<?php //echo $layoutcode ?>
	<?php echo trim($layoutcode) ?>
	<!-- End Page Layout Code -->
	<?php
	if (Kohana::$profiling)
	{
		echo View::factory('profiler/console');
	}
	?>
	<?php echo Page::script_render(); ?>
</body>
</html>
