<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span3">
		<ul id="admin-cms-field-list" class="nav nav-tabs nav-stacked">
		<?php foreach ($fields AS $field): ?>
			<li id="admin-cms-field-list-item-<?php echo $field->id ?>">
				<a href="#"
					data-id="<?php echo $field->id ?>"
					data-name="<?php echo $field->name ?>"
					data-title="<?php echo $field->title ?>"
					data-description="<?php echo $field->description ?>"
					data-order="<?php echo $field->order ?>"
					data-type="<?php echo $field->type ?>"
					data-config='<?php echo json_encode($field->config) ?>'
				>
					<?php echo $field->title ?>
					<small class="pull-right muted"><?php echo $field->name ?></small>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<div class="span9">
		<hr />
		<?php
		$field = ORM::factory('CMS_Field');
		echo View::factory('page/cms/field/form', array(
			'field'	=> $field,
		));
		?>
	</div>
</div>

