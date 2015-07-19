<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span9">
		<table
			id="admin-page-snippet-table"
			class="table table-hover editable-table"
			data-delete-callback="<?php echo Route::url('page-admin', array('controller' => 'Snippet', 'action' => 'delete')) ?>"
			data-delete-title="<?php echo __('Are you sure to delete this snippet?') ?>"
			data-newitem-callback="<?php echo Route::url('page-admin', array('controller' => 'Snippet', 'action' => 'newitem')) ?>"
		>
			<caption><?php echo __('Snippet List') ?></caption>
			<thead>
				<tr>
					<th><?php echo __('Snippet ID') ?></th>
					<th><?php echo __('Snippet Name') ?></th>
					<th><?php echo __('Snippet Title') ?></th>
					<th width="80"><?php echo __('Action') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($snippets AS $snippet): ?>
				<tr id="admin-page-snippet-item-<?php echo $snippet->id ?>">
					<td class="id"><?php echo $snippet->id ?></td>
					<td class="name">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Snippet', 'action' => 'update')) ?>"
							data-pk="<?php echo $snippet->id ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the snippet name.') ?>"
							data-value="<?php echo $snippet->name ?>"
						><?php echo $snippet->name ?></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Snippet', 'action' => 'update')) ?>"
							data-pk="<?php echo $snippet->id ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the snippet title.') ?>"
							data-value="<?php echo $snippet->title ?>"
						><?php echo $snippet->title ?></a>
					</td>
					<td class="actions">
						<a class="btn btn-mini btn-info" href="<?php echo Route::url('page-admin', array(
							'controller'	=> 'Snippet',
							'action'		=> 'edit',
							'params'		=> $snippet->id,
						)) ?>"><?php echo __('Edit') ?></a>
						<button class="btn btn-mini btn-danger delete" data-id="<?php echo $snippet->id ?>"><?php echo __('Delete') ?></button>
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
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Snippet', 'action' => 'update')) ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the snippet name.') ?>"
							data-value=""
						></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Snippet', 'action' => 'update')) ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the snippet title.') ?>"
							data-value=""
						></a>
					</td>
					<td class="actions">
						<button class="btn btn-mini btn-primary submit"><?php echo __('Submit') ?></button>
						<button class="btn btn-mini btn-danger delete"><?php echo __('Delete') ?></button>
					</td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td>
						<button class="btn btn-primary btn-block add-column"><?php echo __('Add') ?></button>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="span3">
		<div class="well">
		</div>
	</div>
</div>
