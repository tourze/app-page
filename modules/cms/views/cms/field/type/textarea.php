<?php defined('SYSPATH') OR die('No direct access allowed.');

// 默认不显示前台
if ( ! isset($front))
{
	$front = FALSE;
}

if ( ! isset($name))
{
	$name = 'config[1]';
}
if ( ! isset($id))
{
	$id = 'field-type-config-1';
}
if ( ! isset($class))
{
	$class = 'span12';
}

if ( ! isset($length))
{
	$length = 0;
}

if ( ! isset($value))
{
	$value = '';
}
if (isset($default))
{
	$value = $default;
}

// 是否使用可视化编辑器
if ( ! isset($wysiwyg))
{
	$wysiwyg = FALSE;
}

?>

<?php if ($front): ?>
<textarea name="<?php echo $name ?>" id="<?php echo $id ?>" class="<?php echo $class ?>"><?php echo $value ?></textarea>
<?php else: ?>
<label>
	<?php echo __('Default Value') ?>
	<textarea name="<?php echo $name ?>[default]" id="<?php echo $id ?>-default" class="<?php echo $class ?>" placeholder="<?php echo __('Default Value') ?>"><?php echo $value ?></textarea>
</label>
<label>
	<?php echo __('Length Limit') ?>
	<input type="text" name="<?php echo $name ?>[length]" id="<?php echo $id ?>-length" class="<?php echo $class ?>" placeholder="<?php echo __('Length Limit') ?>" value="<?php echo $length ?>" />
</label>
<label class="checkbox inline">
	<input id="<?php echo $id ?>-wysiwyg" type="checkbox" name="<?php echo $name ?>[wysiwyg]" value="1" <?php if ($wysiwyg) { ?>checked<?php } ?> />
	<?php echo __('Using WYSIWYG Editor') ?>
</label>
<?php endif; ?>

