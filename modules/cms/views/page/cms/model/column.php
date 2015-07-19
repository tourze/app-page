<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="control-group admin-cms-model-field-group">
	<div class="control-label admin-cms-model-field-select-control">
		<select class="admin-cms-model-field-select" name="column[<?php echo $model->id ?>][]">
		<?php foreach ($fields AS $field): ?>
			<option value="<?php echo $field->id ?>"><?php echo $field->title ?>(<?php echo $field->name ?>)</option>
		<?php endforeach; ?>
		</select>
		<div class="row-fluid">
			<div class="span6"><button class="btn btn-block default"><?php echo __('Default') ?></button></div>
			<div class="span6"><button class="btn btn-block btn-danger delete" data-title="<?php echo __('Are you sure to delete this column?') ?>"><?php echo __('Delete') ?></button></div>
		</div>
		<!--<div class="row-fluid move">
			<div class="span6"><button class="btn btn-block"><?php echo __('Move Up') ?></button></div>
			<div class="span6"><button class="btn btn-block"><?php echo __('Move Down') ?></button></div>
		</div>-->
	</div>
	<div class="controls">
		<?php
		$i = 0;
		foreach ($fields AS $field)
		{
		?>
		<div data-id="<?php echo $field->id ?>" class="field-type-config"<?php if ($i > 0) { ?> style="display:none"<?php } ?>>
			<!--<?php print_r($field->config); ?>-->
			<?php echo View::factory("cms/field/type/".$field->type(), $field->config) ?>
		</div>
		<?php
			$i++;
		}
		?>
	</div>
</div>


