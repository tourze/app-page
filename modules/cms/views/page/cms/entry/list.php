<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span3">
		<ul id="admin-cms-entry-model-list" class="nav nav-tabs nav-stacked">
		<?php foreach ($models AS $model): ?>
			<li
				id="admin-cms-entry-model-list-item-<?php echo $model->id ?>"
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
</div>

