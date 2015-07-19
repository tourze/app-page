<?php defined('SYSPATH') OR die('No direct script access.'); ?>

<div class="row-fluid">
	<div class="span9">
		<table
			id="admin-auth-field-table"
			class="table table-hover editable-table"
			data-delete-callback="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'delete')) ?>"
			data-delete-title="<?php echo __('Are you sure to delete this field?') ?>"
			data-newitem-callback="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'newitem')) ?>"
			data-set-login-callback="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'set_login')) ?>"
		>
			<caption><?php echo __('Field List') ?></caption>
			<thead>
				<tr>
					<th><?php echo __('Field ID') ?></th>
					<th><?php echo __('Field Name') ?></th>
					<th><?php echo __('Field Title') ?></th>
					<th><?php echo __('Field Order') ?></th>
					<th><?php echo __('Field Filters') ?></th>
					<th><?php echo __('Default Value') ?></th>
					<th><?php echo __('Field Description') ?></th>
					<th width="80"><?php echo __('Action') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($fields AS $field): ?>
				<tr id="admin-auth-field-item-<?php echo $field->id ?>">
					<td class="id"><?php echo $field->id ?></td>
					<td class="name">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-pk="<?php echo $field->id ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the field name.') ?>"
							data-value="<?php echo $field->name ?>"
						><?php echo $field->name ?></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-pk="<?php echo $field->id ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the field title.') ?>"
						><?php echo $field->title ?></a>
					</td>
					<td class="order">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-pk="<?php echo $field->id ?>"
							data-name="order"
							data-title="<?php echo __('Please enter the field order.') ?>"
						><?php echo $field->order ?></a>
					</td>
					<td class="filters">
						<a
							href="#"
							class="editable"
							data-type="checklist"
							data-placement="bottom"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-pk="<?php echo $field->id ?>"
							data-name="filters"
							data-value="<?php echo $field->filters ?>"
							data-separator="<?php echo Model_Auth_Field::FILTER_SEPARATOR ?>"
							data-source='<?php echo json_encode($field->checklist_filters()) ?>'
							data-title="<?php echo __('Please select field filters.') ?>"
						></a>
					</td>
					<td class="default">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-pk="<?php echo $field->id ?>"
							data-name="default"
							data-title="<?php echo __('Please enter the default value.') ?>"
						><?php echo $field->default ?></a>
					</td>
					<td class="description">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-pk="<?php echo $field->id ?>"
							data-name="description"
							data-title="<?php echo __('Please enter the field description.') ?>"
						><?php echo $field->description ?></a>
					</td>
					<td class="actions">
						<?php
						$login_class = 'btn-info';
						?>
						<a class="btn btn-mini <?php if ($field->login) { echo $login_class; } ?> login" data-id="<?php echo $field->id ?>" data-value="<?php echo $field->login ?>" data-class="<?php echo $login_class ?>" title="<?php echo __('Set as a login column') ?>" href="#"><?php echo __('Login') ?></a>
						<button class="btn btn-mini btn-danger delete" data-id="<?php echo $field->id ?>"><?php echo __('Delete') ?></button>
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
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-name="name"
							data-value=""
							data-title="<?php echo __('Please enter the field name.') ?>"
						></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-name="title"
							data-value=""
							data-title="<?php echo __('Please enter the field title.') ?>"
						></a>
					</td>
					<td class="order">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-name="order"
							data-value=""
							data-title="<?php echo __('Please enter the field order.') ?>"
						></a>
					</td>
					<td class="filters">
						<a
							href="#"
							class="editable"
							data-type="checklist"
							data-placement="bottom"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-name="filters"
							data-value="0"
							data-separator="<?php echo Model_Auth_Field::FILTER_SEPARATOR ?>"
							data-source='<?php echo json_encode($field->checklist_filters()) ?>'
							data-title="<?php echo __('Please select field filters.') ?>"
						></a>
					</td>
					<td class="default">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-name="default"
							data-value=""
							data-title="<?php echo __('Please enter the default value.') ?>"
						></a>
					</td>
					<td class="description">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('auth-admin', array('controller' => 'Field', 'action' => 'update')) ?>"
							data-name="description"
							data-value=""
							data-title="<?php echo __('Please enter the field description.') ?>"
						></a>
					</td>
					<td class="actions">
						<button class="btn btn-mini btn-primary submit"><?php echo __('Submit') ?></button>
						<button class="btn btn-mini btn-danger delete"><?php echo __('Delete') ?></button>
					</td>
				</tr>

				<tr>
					<td colspan="7"></td>
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

