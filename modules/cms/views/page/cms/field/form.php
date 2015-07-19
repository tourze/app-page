<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<form
	id="admin-cms-field-form"
	class="form-horizontal"
	method="post"
	action="<?php echo Route::url('cms-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
>
	<div class="control-group">
		<label class="control-label" for="field-title"><?php echo $field->label('title') ?></label>
		<div class="controls">
			<input type="text" id="field-title" class="span12" name="title" placeholder="<?php echo $field->label('title') ?>" value="<?php echo $field->title ?>" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="field-name"><?php echo $field->label('name') ?></label>
		<div class="controls">
			<input type="text" id="field-name" name="name" class="span12" placeholder="<?php echo $field->label('name') ?>" value="<?php echo $field->name ?>" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="field-description"><?php echo $field->label('description') ?></label>
		<div class="controls">
			<textarea id="field-description" class="span12" name="description" placeholder="<?php echo $field->label('description') ?>" ><?php echo $field->description ?></textarea>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="field-order"><?php echo $field->label('order') ?></label>
		<div class="controls">
			<input type="text" id="field-order" class="span12" name="order" placeholder="<?php echo $field->label('order') ?>" value="0" />
		</div>
	</div>
	<hr />
	<div class="control-group">
		<label class="control-label" for="field-type"><?php echo $field->label('type') ?></label>
		<div class="controls">
			<select id="field-type" name="type">
				<?php foreach (Model_CMS_Field::$types AS $value => $config): ?>
				<option value="<?php echo $value ?>"><?php echo $config['title'] ?>（<?php echo $config['name'] ?>）</option>
				<?php endforeach ?>
			</select>
			<hr />
			<?php foreach (Model_CMS_Field::$types AS $value => $config): ?>
			<div id="field-type-config-<?php echo $value ?>" class="field-type-config"<?php if ($value != Model_CMS_Field::$default_type) { ?> style="display:none"<?php } ?>>
				<?php echo View::factory("cms/field/type/{$config['name']}") ?>
			</div>
			<?php endforeach ?>
		</div>
	</div>
	<hr />
	<div id="admin-cms-field-form-actions" class="control-group">
		<div class="controls">
			<input type="hidden" name="id" id="field-id" value="" />
			<button type="submit" class="btn btn-primary btn-large"><?php echo __('Submit') ?></button>
			<button class="btn btn-large clear"><?php echo __('Clear') ?></button>
			<button
				class="btn btn-large btn-danger delete"
				data-id=""
				data-title="<?php echo __('Are you sure to delete this field?') ?>"
				data-callback="<?php echo Route::url('cms-admin', array('controller' => 'Field', 'action' => 'delete')) ?>"
				disabled
			><?php echo __('Delete') ?></button>
		</div>
	</div>
</form>

