<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="row-fluid">
	<div class="span3">
		<button id="note-add" class="btn btn-block btn-large btn-info">新增笔记</button>
		<hr />
		<input type="text" id="note-list-search-input" class="span12" placeholder="输入关键词搜索标题" />
		<ul
			id="note-list-nav"
			class="nav nav-tabs nav-stacked"
			data-callback="<?php echo Route::url('cloud-admin', array('controller' => 'Note', 'action' => 'list')) ?>"
			data-get-callback="<?php echo Route::url('cloud-admin', array('controller' => 'Note', 'action' => 'get')) ?>"
		>
			<li><a href="#" class="text-center">LOADING</a></li>
		</ul>
	</div>
	<div class="span9">
		<div class="well clearfix">
			<form action="" method="post">
				<input type="text" name="title" id="note-title" class="span12" placeholder="请输入笔记标题" />
				<?php echo View::factory('cloud/editor') ?>
				<div id="note-actions" class="clearfix">
					<button
						id="note-delete"
						class="btn btn-danger"
						data-id=""
						data-callback="<?php echo Route::url('cloud-admin', array('controller' => 'Note', 'action' => 'delete')) ?>"
					>删除</button>
					<button
						id="note-save"
						class="btn btn-primary"
						data-id=""
						data-callback="<?php echo Route::url('cloud-admin', array('controller' => 'Note', 'action' => 'edit')) ?>"
					>保存</button>
				</div>
			</form>
		</div>
		<!--<pre id="debug"></pre>-->
	</div>
</div>

