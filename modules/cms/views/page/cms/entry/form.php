<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<form class="form-horizontal" method="post">
	<legend><?php
	if ($entry->loaded())
	{
		echo __('Edit entry');
	}
	else
	{
		echo __('Add new :model', array(':model' => $model->title));
	}
	?></legend>
<?php if ($entry->loaded()): ?>
	<div class="control-group">
		<label class="control-label"><?php echo __('Entry ID') ?></label>
		<div class="controls">
			<input type="text" value="<?php echo $entry->id ?>" disabled />
			
		</div>
	</div>
<?php endif; ?>
<?php
// 查找该模型的所有可用字段
$fields = $model
	->fields
	->find_all()
	;
// 获取所有属性
$attributes = $entry
	->attributes
	->find_all()
	->as_array('field_id')
	;
foreach ($fields AS $field)
{
	$append = array();
	$css_id = "entry-{$field->name}-{$field->id}";
	$append['id'] = $css_id;
	if (isset($attributes[$field->id]))
	{
		$append['value'] = $attributes[$field->id]->value;
	}
?>
	<div class="control-group">
		<label class="control-label" for="<?php echo $css_id ?>"><?php echo $field->title ?></label>
		<div class="controls">
			<?php echo $field->display_input($append) ?>
		</div>
	</div>
<?php
}
?>
	<hr />
	<div class="control-group">
		<div class="controls">
		<button type="submit" class="btn btn-large btn-primary"><?php echo __('Submit') ?></button>
		</div>
	</div>
</form>

