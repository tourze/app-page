<?php defined('SYSPATH') OR die('No direct script access.'); ?>
<div class="row-fluid">
	<div class="span9">

		<table
			id="admin-page-redirect-table"
			class="table table-hover editable-table"
			data-delete-callback="<?php echo Route::url('page-admin', array('controller' => 'Redirect', 'action' => 'delete')) ?>"
			data-delete-title="<?php echo __('Are you sure to delete this redirect?') ?>"
			data-newitem-callback="<?php echo Route::url('page-admin', array('controller' => 'Redirect', 'action' => 'newitem')) ?>"
		>
			<caption><?php echo __('Redirect List') ?></caption>
			<thead>
				<tr>
					<th><?php echo __('Redirect ID') ?></th>
					<th><?php echo __('Old URL') ?></th>
					<th><?php echo __('New URL') ?></th>
					<th><?php echo __('Redirect Type') ?></th>
					<th width="80"><?php echo __('Action') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($redirects AS $redirect): ?>
				<tr id="admin-page-layout-item-<?php echo $redirect->id ?>">
					<td class="id"><?php echo $redirect->id ?></td>
					<td class="url">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Redirect', 'action' => 'update')) ?>"
							data-pk="<?php echo $redirect->id ?>"
							data-name="url"
							data-title="<?php echo __('Please enter the old url.') ?>"
							data-value="<?php echo $redirect->url ?>"
						><?php echo $redirect->url ?></a>
					</td>
					<td class="newurl">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Redirect', 'action' => 'update')) ?>"
							data-pk="<?php echo $redirect->id ?>"
							data-name="newurl"
							data-title="<?php echo __('Please enter the new url.') ?>"
							data-value="<?php echo $redirect->newurl ?>"
						><?php echo $redirect->newurl ?></a>
					</td>
					<td class="type">
						<a
							href="#"
							class="editable"
							data-type="select"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Redirect', 'action' => 'update')) ?>"
							data-pk="<?php echo $redirect->id ?>"
							data-name="type"
							data-source='<?php echo $redirect->status_json() ?>'
							data-title="<?php echo __('Please select the redirect type.') ?>"
							data-value="<?php echo $redirect->type ?>"
						><?php echo $redirect->type ?></a>
					</td>
					<td class="actions">
						<a class="btn btn-mini btn-info" href="<?php echo Route::url('page-admin', array(
							'controller'	=> 'Redirect',
							'action'		=> 'edit',
							'params'		=> $redirect->id,
						)) ?>"><?php echo __('Edit') ?></a>
						<button class="btn btn-mini btn-danger delete" data-id="<?php echo $redirect->id ?>"><?php echo __('Delete') ?></button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr class="new-item template">
					<td class="id">#</td>
					<td class="url">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Redirect', 'action' => 'update')) ?>"
							data-name="url"
							data-title="<?php echo __('Please enter the old url.') ?>"
							data-value=""
						></a>
					</td>
					<td class="newurl">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Redirect', 'action' => 'update')) ?>"
							data-name="newurl"
							data-title="<?php echo __('Please enter the new url.') ?>"
							data-value=""
						></a>
					</td>
					<td class="type">
						<a
							href="#"
							class="editable"
							data-type="select"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Redirect', 'action' => 'update')) ?>"
							data-pk="<?php echo $redirect->id ?>"
							data-name="type"
							data-source='<?php echo $redirect->status_json() ?>'
							data-title="<?php echo __('Please select the redirect type.') ?>"
							data-value="<?php echo $redirect->type ?>"
						><?php echo $redirect->type ?></a>
					</td>
					<td class="actions">
						<button class="btn btn-mini btn-primary submit"><?php echo __('Submit') ?></button>
						<button class="btn btn-mini btn-danger delete"><?php echo __('Delete') ?></button>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
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
