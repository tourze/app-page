<?php defined('SYSPATH') OR die('No direct script access.'); ?>

<div class="row-fluid">
	<div class="span9">
		<table class="table table-bordered table-hover editable-table">
			<thead>
				<tr>
					<th width="150"><?php echo __('Field') ?></th>
					<th><?php echo __('Value') ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo __('Module ID') ?></td>
					<td><?php echo $module->id ?></td>
				</tr>
				<tr>
					<td><?php echo __('Module Name') ?></td>
					<td>
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
				</tr>
				<tr>
					<td><?php echo __('Module Title') ?></td>
					<td>
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
				</tr>
				<tr>
					<td><?php echo __('Module Description') ?></td>
					<td>
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'update')) ?>"
							data-pk="<?php echo $module->id ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the module description.') ?>"
							data-value="<?php echo $module->description ?>"
						><?php echo $module->description ?></a>
					</td>
				</tr>
				<tr>
					<td><?php echo __('Module Order') ?></td>
					<td>
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
				</tr>
			<?php if ($module->date_created): ?>
				<tr>
					<td><?php echo __('Date Created') ?></td>
					<td><?php echo date('Y-m-d H:i:s', $module->date_created) ?></td>
				</tr>
			<?php endif; ?>
			<?php if ($module->date_updated): ?>
				<tr>
					<td><?php echo __('Date Updated') ?></td>
					<td><?php echo date('Y-m-d H:i:s', $module->date_updated) ?></td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>

		<table
			id="admin-auth-action-table"
			class="table table-hover editable-table"
			data-delete-callback="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'delete')) ?>"
			data-delete-title="<?php echo __('Are you sure to delete this action?') ?>"
			data-newitem-callback="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'newitem')) ?>"
			data-append='<?php echo json_encode(array('module_id' => $module->id)) ?>'
		>
			<caption><?php echo __('Action List') ?></caption>
			<thead>
				<tr>
					<th><?php echo __('Action ID') ?></th>
					<th><?php echo __('Action Name') ?></th>
					<th><?php echo __('Action Title') ?></th>
					<th><?php echo __('Action Description') ?></th>
					<th><?php echo __('Action Order') ?></th>
					<th width="80"><?php echo __('Action') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($module->actions->find_all() AS $action): ?>
				<tr id="admin-auth-action-item-<?php echo $action->id ?>">
					<td class="id"><?php echo $action->id ?></td>
					<td class="name">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'update')) ?>"
							data-pk="<?php echo $action->id ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the action name.') ?>"
							data-value="<?php echo $action->name ?>"
						><?php echo $action->name ?></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'update')) ?>"
							data-pk="<?php echo $action->id ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the action title.') ?>"
							data-value="<?php echo $action->title ?>"
						><?php echo $action->title ?></a>
					</td>
					<td class="description">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'update')) ?>"
							data-pk="<?php echo $action->id ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the action description.') ?>"
						><?php echo $action->description ?></a>
					</td>
					<td class="order">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'update')) ?>"
							data-pk="<?php echo $action->id ?>"
							data-name="order"
							data-title="<?php echo __('Please enter the action order.') ?>"
							data-value="<?php echo $action->order ?>"
						><?php echo $action->order ?></a>
					</td>
					<td class="actions">
						<button class="btn btn-mini btn-danger delete" data-id="<?php echo $action->id ?>"><?php echo __('Delete') ?></button>
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
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'update')) ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the action name.') ?>"
						></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'update')) ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the action title.') ?>"
						></a>
					</td>
					<td class="description">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'update')) ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the action description.') ?>"
						></a>
					</td>
					<td class="order">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Action', 'action' => 'update')) ?>"
							data-name="order"
							data-title="<?php echo __('Please enter the action order.') ?>"
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
		<a href="<?php echo Route::url('auth-admin', array('controller' => 'Module', 'action' => 'list')) ?>" class="btn btn-large btn-block btn-info"><?php echo __('Module List') ?></a>
	</div>
</div>

