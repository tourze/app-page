<?php defined('SYSPATH') OR die('No direct script access.'); ?>

<div class="row-fluid">
	<div class="span9">
		<table
			id="admin-auth-role-table"
			class="table table-hover editable-table"
			data-delete-callback="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'delete')) ?>"
			data-delete-title="<?php echo __('Are you sure to delete this role?') ?>"
			data-newitem-callback="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'newitem')) ?>"
		>
			<caption><?php echo __('Role List') ?></caption>
			<thead>
				<tr>
					<th><?php echo __('Role ID') ?></th>
					<th><?php echo __('Role Name') ?></th>
					<th><?php echo __('Role Title') ?></th>
					<th><?php echo __('Role Description') ?></th>
					<th><?php echo __('Role Order') ?></th>
					<th width="80"><?php echo __('Action') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($roles AS $role): ?>
				<tr id="admin-auth-role-item-<?php echo $role->id ?>">
					<td class="id"><?php echo $role->id ?></td>
					<td class="name">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-pk="<?php echo $role->id ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the role name.') ?>"
							data-value="<?php echo $role->name ?>"
						><?php echo $role->name ?></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-pk="<?php echo $role->id ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the role title.') ?>"
							data-value="<?php echo $role->title ?>"
						><?php echo $role->title ?></a>
					</td>
					<td class="description">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-pk="<?php echo $role->id ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the role description.') ?>"
						><?php echo $role->description ?></a>
					</td>
					<td class="order">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-pk="<?php echo $role->id ?>"
							data-name="order"
							data-title="<?php echo __('Please enter the role order.') ?>"
							data-value="<?php echo $role->order ?>"
						><?php echo $role->order ?></a>
					</td>
					<td class="actions">
						<a class="btn btn-mini btn-info" href="<?php echo Route::url('auth-admin', array(
							'controller'	=> 'Role',
							'action'		=> 'edit',
							'params'		=> $role->id,
						)) ?>"><?php echo __('Edit') ?></a>
						<button class="btn btn-mini btn-danger delete" data-id="<?php echo $role->id ?>"><?php echo __('Delete') ?></button>
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
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the role name.') ?>"
							data-value=""
						></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the role title.') ?>"
							data-value=""
						></a>
					</td>
					<td class="description">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the role description.') ?>"
						></a>
					</td>
					<td class="order">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-name="order"
							data-title="<?php echo __('Please enter the role order.') ?>"
							data-value=""
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

