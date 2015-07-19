<div
	id="gduf-mailbox"
	class="row-fluid"
	style="display:none;"
	data-people-search-callback="<?php echo Route::url('gduf-mail-action', array('action' => 'people_search')) ?>"
	data-annex-list-callback="<?php echo Route::url('gduf-mail-action', array('action' => 'annex_list')) ?>"
>
	<div id="gduf-menu" class="span2">
		<p style="display:none;" class="username-block text-center">学号：<span class="label label-success username">111586437</span></p>
		<div class="well">
			<ul class="unstyled">
				<li class="inbox active"><a href="#">收信箱</a></li>
				<li class="write"><a href="#send-modal" data-toggle="modal">写邮件</a></li>
				<li class="outbox"><a href="#">发信箱</a></li>
				<li class="draft"><a href="#">草稿箱</a></li>
				<li class="trash"><a href="#">垃圾箱</a></li>
				<li class="logout"><a href="#">退出邮箱</a></li>
			</ul>
		</div>
	</div>
	<div id="mail-content" class="span10">
	</div>
</div>
