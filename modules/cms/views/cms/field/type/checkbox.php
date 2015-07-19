<?php defined('SYSPATH') OR die('No direct access allowed.');

// 默认不显示前台
if ( ! isset($front))
{
	$front = FALSE;
}

?>
<?php if ($front): ?>
<?php foreach ($config['name'] AS $i => $_name): ?>
	<?php if ($_name): ?>
	<label class="checkbox">
		<input type="checkbox" name="<?php echo $name ?>[]" value="<?php echo $config['value'][$i] ?>" <?php if ($config['default'][$i]) { ?>checked<?php } ?> />
		<?php echo $_name ?>
	</label>
	<?php endif; ?>
<?php endforeach; ?>
<?php else: ?>
<table class="table admin-cms-field-checkbox-table">
	<thead>
		<tr>
			<th class="span4"><?php echo __('Name') ?></th>
			<th class="span4"><?php echo __('Value') ?></th>
			<th class="span4"><?php echo __('Action') ?></th>
		</tr>
	</thead>
	<tbody>
	<?php if (isset($name) AND isset($value) AND isset($default)): ?>
	<?php foreach ($name AS $i => $_name): ?>
		<?php
		if ( ! $_name)
		{
			continue;
		}
		?>
		<tr>
			<td><input type="text" class="name-input" value="<?php echo $_name ?>" /></td>
			<td><input type="text" class="value-input" value="<?php echo $value[$i] ?>" /></td>
			<td>
				<button class="btn btn-mini btn-block span6 default<?php if ($default[$i]) { ?> btn-info<?php } ?>"><?php echo __('Default') ?></button>
				<button class="btn btn-mini btn-danger btn-block span6 delete"><?php echo __('Delete') ?></button>
				<input type="hidden" class="default-input" value="<?php echo $default[$i] ?>" />
			</td>
		</tr>
	<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
			</td>
			<td>
				<button class="btn btn-block btn-primary add-new"><?php echo __('Add new column') ?></button>
			</td>
		</tr>
		<tr class="template">
			<td><input type="text" class="name-input" name="config[4][name][]" /></td>
			<td><input type="text" class="value-input" name="config[4][value][]" /></td>
			<td>
				<button class="btn btn-mini btn-block span6 default"><?php echo __('Default') ?></button>
				<button class="btn btn-mini btn-danger btn-block span6 delete"><?php echo __('Delete') ?></button>
				<input type="hidden" class="default-input" name="config[4][default][]" value="0" />
			</td>
		</tr>
	</tfoot>
</table>
<?php endif; ?>

