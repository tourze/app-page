<?php defined('SYSPATH') OR die('No direct access allowed.');
Page::style('socialbbs/css/common.css');
Page::script('socialbbs/js/common.js');
?>
<?php echo View::factory('socialbbs/post') ?>
<div class="row-fluid">
	<div class="span8 offset2">
	<?php
	$i = 10;
	while ($i)
	{
		echo View::factory('socialbbs/topic/item');
		$i--;
	}
	?>
	</div>
</div>
