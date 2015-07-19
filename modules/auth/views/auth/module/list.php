<?php defined('SYSPATH') OR die('No direct script access.'); ?>

<div class="row-fluid">
	<div class="span9">
		<table
			id="admin-auth-module-table"
			class="table table-hover editable-table"
			data-delete-callback="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'delete')) ?>"
			data-delete-title="<?php echo __('Are you sure to delete this module?') ?>"
			data-newitem-callback="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'newitem')) ?>"
		>
			<caption><?php echo __('Module List') ?></caption>
			<thead>
				<tr>
					<th><?php echo __('Module ID') ?></th>
					<th><?php echo __('Module Name') ?></th>
					<th><?php echo __('Module Title') ?></th>
					<th><?php echo __('Module Description') ?></th>
					<th><?php echo __('Module Order') ?></th>
					<th width="80"><?php echo __('Action') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($modules AS $module): ?>
				<tr id="admin-auth-module-item-<?php echo $module->id ?>">
					<td class="id"><?php echo $module->id ?></td>
					<td class="name">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-pk="<?php echo $module->id ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the module name.') ?>"
							data-value="<?php echo $module->name ?>"
						><?php echo $module->name ?></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-pk="<?php echo $module->id ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the module title.') ?>"
							data-value="<?php echo $module->title ?>"
						><?php echo $module->title ?></a>
					</td>
					<td class="description">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-pk="<?php echo $module->id ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the module description.') ?>"
						><?php echo $module->description ?></a>
					</td>
					<td class="order">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-pk="<?php echo $module->id ?>"
							data-name="order"
							data-title="<?php echo __('Please enter the module order.') ?>"
							data-value="<?php echo $module->order ?>"
						><?php echo $module->order ?></a>
					</td>
					<td class="actions">
						<a
							class="btn btn-info btn-mini"
							rel="popover"
							data-html="true"
							data-trigger="hover"
							data-container="body"
							data-title="<?php echo __(":module's actions", array(':module' => $module->name)) ?>"
							data-content="<?php echo $module->list_action_html() ?>"
							href="<?php echo Route::url('auth-admin', array(
								'controller'	=> 'Module',
								'action'		=> 'edit',
								'params'		=> $module->id,
							)) ?>"
						><?php echo __('Action') ?></a>
						<button class="btn btn-mini btn-danger delete" data-id="<?php echo $module->id ?>"><?php echo __('Delete') ?></button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr class="new-item template">
					<td class="id">#</td>
					<td class="name">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the module name.') ?>"
						></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the module title.') ?>"
						></a>
					</td>
					<td class="description">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the module description.') ?>"
						></a>
					</td>
					<td class="order">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-name="order"
							data-title="<?php echo __('Please enter the module order.') ?>"
						></a>
					</td>
					<td class="actions">
						<button class="btn btn-mini btn-primary submit"><?php echo __('Submit') ?></button>
						<button class="btn btn-mini btn-danger delete"><?php echo __('Delete') ?></button>
					</td>
				</tr>
				<tr>
					<td colspan="5"></td>
					<td>
						<button class="btn btn-primary btn-block add-column"><?php echo __('Add') ?></button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="span3">
	</div>
</div>

