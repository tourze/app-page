<?php defined('SYSPATH') OR die('No direct access allowed.');
// 加载额外的媒体文件
Page::script('jquery.treeview/jquery.treeview.js');
Page::script('jquery.treeview/jquery.treeview.edit.js');
Page::script('jquery.treeview/jquery.treeview.async.js');
Page::script('page/js/page.js');
?>
<div class="row-fluid">
	<div class="span9">
		<h4 class="text-center">
			<?php echo __('Pages') ?>
		</h4>
		<hr />
		<ul id="pagetree" data-source="<?php echo Route::url('page-admin', array('controller' => 'Entry', 'action' => 'source')) ?>"></ul>
	</div>
	<div class="span3">
		<div class="well">
			<h2><?php echo __('Help') ?></h2>
			<hr />
			<strong><?php echo __('Create a new page') ?></strong>
			<p><?php echo __('To create a new page, hover over the parent, or the page you want the new page to be under, and click on "add".') ?></p>
			<hr />
			<strong><?php echo __('Edit a page') ?></strong>
			<p><?php echo __('To edit a page, hover over it, and click "edit".') ?></p>
			<hr />
			<strong><?php echo __('Delete a page') ?></strong>
			<p><?php echo __('To delete a page, hover over it and click "delete". You will be asked to confirm before the page is deleted.') ?></p>
			<hr />
			<strong><?php echo __('Move a page') ?></strong>
			<p><?php echo __('To move a page (and all of its children, if it has any), hover over it and click "move".') ?></p>
			<hr />
			<strong><?php echo __('View a page') ?></strong>
			<p><?php echo __('To view what a pages looks like, hover over it and click "view".') ?></p>
		</div>
	</div>
</div>
