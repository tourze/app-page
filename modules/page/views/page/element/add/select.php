<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="grid_16">
	<div class="box">
		<h1><?php echo __('Adding :element', array(':element' => __(ucfirst($element->type())))) ?></h1>
		
		<?php include Kohana::find_file('views', 'page/error') ?>
		
		<form method="post">
			
			<p>
				<label for="which"><?php echo __('Select a :element', array(':element' => __(ucfirst($element->type())))) ?></label>
				<?php
				$choices = $element->select_list($element->pk());
				echo Form::select('element', $choices, $element->id);
				?>
			</p>
			
			<p>
				<?php echo Form::submit('submit',__('Add Element'), array('class' => 'btn btn-primary')) ?>
				<?php echo HTML::anchor(Route::url('page-admin', array(
					'controller' => 'Entry',
					'action' => 'edit',
					'params' => $page
				)), __('cancel')); ?>
			</p>
		</form>
		</div>
	</div>
</div>
