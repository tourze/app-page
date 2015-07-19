<?php defined('SYSPATH') OR die('No direct script access.'); ?>
<div class="row-fluid">
	<div class="span9">
		<table
			id="admin-auth-user-table"
			class="table table-hover editable-table"
			data-delete-callback="<?php echo Route::url('auth-admin', array('controller' => 'User', 'action' => 'delete')) ?>"
			data-delete-title="<?php echo __('Are you sure to delete this user?') ?>"
			data-newitem-callback="<?php echo Route::url('auth-admin', array('controller' => 'User', 'action' => 'newitem')) ?>"
		>
			<caption><?php echo __('User List') ?></caption>
			<thead>
				<tr>
					<th><?php echo __('User ID') ?></th>
					<th><?php echo __('Password') ?></th>
					<?php foreach ($fields AS $field): ?>
						<th><?php echo $field->title ?></th>
					<?php endforeach; ?>
					<th width="80"><?php echo __('Action') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($users AS $user): ?>
				<tr id="admin-auth-user-item-<?php echo $user->id ?>">
					<td class="id"><?php echo $user->id ?></td>
					<td class="password">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'User', 'action' => 'update')) ?>"
							data-pk="<?php echo $user->id ?>"
							data-name="password"
							data-title="<?php echo __('Please enter the user password.') ?>"
							data-value="******"
						>******</a>
					</td>
					<?php foreach ($fields AS $field): ?>
						<td class="<?php echo $field->name ?>">
							<a
								href="#"
								class="editable"
								data-type="text"
								data-url="<?php echo Route::url('auth-admin', array('controller' => 'User', 'action' => 'update')) ?>"
								data-pk="<?php echo $user->id ?>"
								data-name="<?php echo $field->name ?>"
								data-title="<?php echo __('Please enter the ' . $field->name . ' value.') ?>"
								data-value="<?php echo $user->{$field->name} ?>"
							><?php echo $user->{$field->name} ?></a>
						</td>
					<?php endforeach; ?>
					<td class="actions">
						<a
							class="btn btn-info btn-mini"
							href="<?php echo Route::url('auth-admin', array(
								'controller'	=> 'User',
								'action'		=> 'edit',
								'params'		=> $user->id,
							)) ?>"
						><?php echo __('Edit') ?></a>
						<button class="btn btn-mini btn-danger delete" data-id="<?php echo $user->id ?>"><?php echo __('Delete') ?></button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr class="new-item template">
					<td class="id">#</td>
					<td class="password">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'User', 'action' => 'update')) ?>"
							data-name="password"
							data-title="<?php echo __('Please enter the user password.') ?>"
						></a>
					</td>
					<?php
					$colspan = 2; // 默认为2
					foreach ($fields AS $field)
					{
						$colspan++;
					?>
						<td class="<?php echo $field->name ?>">
							<a
								href="#"
								class="editable"
								data-type="text"
								data-url="<?php echo Route::url('auth-admin', array('controller' => 'User', 'action' => 'update')) ?>"
								data-name="<?php echo $field->name ?>"
								data-title="<?php echo __('Please enter the ' . $field->name . ' value.') ?>"
							></a>
						</td>
					<?php
					}
					?>
					<td class="actions">
						<button class="btn btn-mini btn-primary submit"><?php echo __('Submit') ?></button>
						<button class="btn btn-mini btn-danger delete"><?php echo __('Delete') ?></button>
					</td>
				</tr>
				<tr>
					<td colspan="<?php echo $colspan ?>"></td>
					<td>
						<button class="btn btn-primary btn-block add-column"><?php echo __('Add') ?></button>
					</td>
				</tr>
			</tfoot>
		</table>
		<?php echo $pagination ?>
	</div>
	<div class="span3">
	</div>
</div>

