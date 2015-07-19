<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span3">
		<ul id="admin-cms-model-list" class="nav nav-tabs nav-stacked">
		<?php foreach ($models AS $model): ?>
			<li id="admin-cms-model-list-item-<?php echo $model->id ?>">
				<a href="#"
					data-id="<?php echo $model->id ?>"
					data-name="<?php echo $model->name ?>"
					data-title="<?php echo $model->title ?>"
					data-description="<?php echo $model->description ?>"
					data-order="<?php echo $model->order ?>"
					data-fields='<?php echo $model->fields_json() ?>'
				>
					<?php echo $model->title ?>
					<small class="pull-right muted"><?php echo $model->name ?></small>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<div class="span9">
		<?php
		$model = ORM::factory('CMS_Model');
		echo View::factory('page/cms/model/form', array(
			'model'		=> $model,
			'fields'	=> $fields,
		));
		?>
	</div>
</div>

