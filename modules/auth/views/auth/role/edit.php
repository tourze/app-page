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
					<td><?php echo __('Role ID') ?></td>
					<td><?php echo $role->id ?></td>
				</tr>
				<tr>
					<td><?php echo __('Role Name') ?></td>
					<td>
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
				</tr>
				<tr>
					<td><?php echo __('Role Title') ?></td>
					<td>
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
				</tr>
				<tr>
					<td><?php echo __('Role Description') ?></td>
					<td>
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update')) ?>"
							data-pk="<?php echo $role->id ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the role description.') ?>"
							data-value="<?php echo $role->description ?>"
						><?php echo $role->description ?></a>
					</td>
				</tr>
				<tr>
					<td><?php echo __('Role Order') ?></td>
					<td>
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
				</tr>
			<?php if ($role->date_created): ?>
				<tr>
					<td><?php echo __('Date Created') ?></td>
					<td><?php echo date('Y-m-d H:i:s', $role->date_created) ?></td>
				</tr>
			<?php endif; ?>
			<?php if ($role->date_updated): ?>
				<tr>
					<td><?php echo __('Date Updated') ?></td>
					<td><?php echo date('Y-m-d H:i:s', $role->date_updated) ?></td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
		
		<?php
		$role_actions = $role
			->actions
			->find_all()
			->as_array('action_id')
			;
		$class_name = 'btn-info';
		?>
		<table
			id="admin-auth-role-action-table"
			class="table table-hover"
			data-callback="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'update_action')) ?>"
		>
			<tbody>
				<?php foreach ($modules AS $module): ?>
				<tr class="info module">
					<td colspan="4"><strong><?php echo $module->title ?></strong> (<?php echo $module->name ?>)</td>
				</tr>
					<?php foreach ($module->actions->find_all() AS $action): ?>
					<tr>
						<td colspan="3"><strong><?php echo $action->title ?></strong> (<?php echo $action->name ?>)</td>
						<td class="actions">
							<div class="btn-group pull-right" data-value="<?php echo $action->id ?>">
								<button class="btn btn-mini <?php if (isset($role_actions[$action->id])) { echo $class_name; } ?>"><?php echo __('Enabled') ?></button>
								<button class="btn btn-mini <?php if (isset($role_actions[$action->id])) { echo $class_name; } ?>"><?php echo __('Disabled') ?></button>
							</div>
						</td>
					</tr>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="span3">
		<a href="<?php echo Route::url('auth-admin', array('controller' => 'Role', 'action' => 'list')) ?>" class="btn btn-large btn-block btn-info"><?php echo __('Role List') ?></a>
	</div>
</div>

