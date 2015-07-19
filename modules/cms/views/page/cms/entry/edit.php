<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span3">
		<ul id="admin-cms-entry-model-list" class="nav nav-tabs nav-stacked">
		<?php foreach ($models AS $model): ?>
			<li
				id="admin-cms-entry-model-list-item-<?php echo $model->id ?>"
				<?php if ($current_model->id == $model->id) { ?>class="active"<?php } ?>
			>
			<a href="<?php echo Route::url('cms-admin', array('controller' => 'Entry', 'action' => 'add', 'params' => $model->id)) ?>"
					data-id="<?php echo $model->id ?>"
				>
					<?php echo $model->title ?>
					<small class="pull-right muted"><?php echo $model->name ?></small>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<div class="span9">
		<?php
		echo View::factory('page/cms/entry/form', array(
			'model'		=> $current_model,
			'entry'		=> $entry,
		));
		?>
	</div>
</div>

