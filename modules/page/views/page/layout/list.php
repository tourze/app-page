<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span9">

		<table
			id="admin-page-layout-table"
			class="table table-hover editable-table"
			data-delete-callback="<?php echo Route::url('page-admin', array('controller' => 'Layout', 'action' => 'delete')) ?>"
			data-delete-title="<?php echo __('Are you sure to delete this layout?') ?>"
			data-newitem-callback="<?php echo Route::url('page-admin', array('controller' => 'Layout', 'action' => 'newitem')) ?>"
		>
			<caption><?php echo __('Layout List') ?></caption>
			<thead>
				<tr>
					<th><?php echo __('Layout ID') ?></th>
					<th><?php echo __('Layout Name') ?></th>
					<th><?php echo __('Layout Title') ?></th>
					<th><?php echo __('Layout Description') ?></th>
					<th width="80"><?php echo __('Action') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($layouts AS $layout): ?>
				<tr id="admin-page-layout-item-<?php echo $layout->id ?>">
					<td class="id"><?php echo $layout->id ?></td>
					<td class="name">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Layout', 'action' => 'update')) ?>"
							data-pk="<?php echo $layout->id ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the layout name.') ?>"
							data-value="<?php echo $layout->name ?>"
						><?php echo $layout->name ?></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Layout', 'action' => 'update')) ?>"
							data-pk="<?php echo $layout->id ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the layout title.') ?>"
							data-value="<?php echo $layout->title ?>"
						><?php echo $layout->title ?></a>
					</td>
					<td class="desc">
						<a
							href="#"
							class="editable"
							data-type="textarea"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Layout', 'action' => 'update')) ?>"
							data-pk="<?php echo $layout->id ?>"
							data-name="desc"
							data-title="<?php echo __('Please enter the layout description.') ?>"
							data-value="<?php echo $layout->desc ?>"
						><?php echo $layout->desc ?></a>
					</td>
					<td class="actions">
						<a class="btn btn-mini btn-info" href="<?php echo Route::url('page-admin', array(
							'controller'	=> 'Layout',
							'action'		=> 'edit',
							'params'		=> $layout->id,
						)) ?>"><?php echo __('Edit') ?></a>
						<button class="btn btn-mini btn-danger delete" data-id="<?php echo $layout->id ?>"><?php echo __('Delete') ?></button>
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
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Layout', 'action' => 'update')) ?>"
							data-name="name"
							data-title="<?php echo __('Please enter the layout name.') ?>"
							data-value=""
						></a>
					</td>
					<td class="title">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Layout', 'action' => 'update')) ?>"
							data-name="title"
							data-title="<?php echo __('Please enter the layout title.') ?>"
							data-value=""
						></a>
					</td>
					<td class="desc">
						<a
							href="#"
							class="editable"
							data-type="text"
							data-url="<?php echo Route::url('page-admin', array('controller' => 'Layout', 'action' => 'update')) ?>"
							data-name="desc"
							data-title="<?php echo __('Please enter the layout description.') ?>"
							data-value=""
						></a>
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
		<div class="well"></div>
	</div>
</div>
