<?php defined('SYSPATH') OR die('No direct access allowed.');

// 默认不显示前台
if ( ! isset($front))
{
	$front = FALSE;
}

if ( ! isset($name))
{
	$name = 'config[0]';
}
if ( ! isset($id))
{
	$id = 'field-type-config-0';
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

?>

<?php if ($front): ?>
<input type="text" name="<?php echo $name ?>" id="<?php echo $id ?>" class="<?php echo $class ?>" value="<?php echo $value ?>" />
<?php else: ?>
<label>
	<?php echo __('Default Value') ?>
	<input type="text" name="<?php echo $name ?>[default]" id="<?php echo $id ?>-default" class="<?php echo $class ?>" placeholder="<?php echo __('Default Value') ?>" value="<?php echo $value ?>" />
</label>
<label>
	<?php echo __('Length Limit') ?>
	<input type="text" name="<?php echo $name ?>[length]" id="<?php echo $id ?>-length" class="<?php echo $class ?>" placeholder="<?php echo __('Length Limit') ?>" value="<?php echo $length ?>" />
</label>
<?php endif; ?>

