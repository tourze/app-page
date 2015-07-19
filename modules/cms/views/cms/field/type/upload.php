<?php defined('SYSPATH') OR die('No direct access allowed.');

// 默认不显示前台
if ( ! isset($front))
{
	$front = FALSE;
}

if ( ! isset($count_label))
{
	$count_label = __('Upload Count Limit');
}
if ( ! isset($name))
{
	$name = 'config[6][limit]';
}
if ( ! isset($id))
{
	$id = 'field-type-config-6-limit';
}
if ( ! isset($class))
{
	$class = 'span12';
}
if ( ! isset($value))
{
	$value = '1';
}
?>
<label>
	<?php echo $count_label ?>
	<input type="text" name="<?php echo $name ?>" id="<?php echo $id ?>" class="<?php echo $class ?>" value="<?php echo $value ?>" />
</label>

