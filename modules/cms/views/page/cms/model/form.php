<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<form id="admin-cms-model-form" action="<?php echo Route::url('cms-admin', array('controller' => 'Model', 'action' => 'update')) ?>" method="post" class="form-horizontal">

	<div class="control-group">
		<label class="control-label" for="model-title"><?php echo $model->label('title') ?></label>
		<div class="controls">
			<input type="text" id="model-title" class="span12" placeholder="<?php echo $model->label('title') ?>" name="title" value="<?php echo $model->title ?>" />
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="model-name"><?php echo $model->label('name') ?></label>
		<div class="controls">
			<input type="text" id="model-name" class="span12" placeholder="<?php echo $model->label('name') ?>" name="name" value="<?php echo $model->name ?>" />
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="model-description"><?php echo $model->label('description') ?></label>
		<div class="controls">
			<textarea id="model-description" class="span12" placeholder="<?php echo $model->label('description') ?>" name="description"><?php echo $model->description ?></textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="model-order"><?php echo $model->label('order') ?></label>
		<div class="controls">
			<input type="text" id="model-order" class="span12" placeholder="<?php echo $model->label('order') ?>" name="order" value="<?php echo $model->order ?>" />
		</div>
	</div>
	
	<hr />

	<div id="admin-cms-model-form-fields" class="control-group">
		<div class="controls">
		<?php foreach ($fields AS $field): ?>
			<label class="checkbox">
				<input id="admin-cms-model-form-fields-item-<?php echo $field->id ?>" class="admin-cms-model-form-fields-item" type="checkbox" name="fields[]" value="<?php echo $field->id ?>" />
				<?php echo $field->title ?> <small><?php echo $field->name ?></small>
			</label>
		<?php endforeach; ?>
		</div>
	</div>
<!--	
	<div id="admin-cms-model-form-columns">
	</div>

	<div id="admin-cms-model-form-add-new" class="control-group">
		<div class="controls">
			<button class="btn btn-info add-new" data-callback="<?php echo Route::url('cms-admin', array('controller' => 'Model', 'action' => 'column')) ?>"><?php echo __('Add new column') ?></button>
		</div>
	</div>
	
	<hr />
-->

	<div id="admin-cms-model-form-actions" class="control-group">
		<div class="controls">
			<input type="hidden" id="model-id" name="id" value="<?php echo $model->id ?>" />
			<button type="submit" class="btn btn-large btn-primary"><?php echo __('Submit') ?></button>
			<button class="btn btn-large clear"><?php echo __('Clear') ?></button>
			<button class="btn btn-large btn-danger delete" data-callback="<?php echo Route::url('cms-admin', array('controller' => 'Model', 'action' => 'delete')) ?>" data-title="<?php echo __('Are you sure to delete this model?') ?>"><?php echo __('Delete') ?></button>
		</div>
	</div>

</form>

