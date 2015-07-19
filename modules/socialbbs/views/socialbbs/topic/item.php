<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div class="well topic-item">
	<div class="head">
		<a class="avatar" href="#">
			<img src="<?php echo Media::url('img/test.jpg') ?>" />
		</a>
		<a class="link" href="##">
			<h5 class="title">这里是个标题你懂的</h5>
			<div class="meta">
				<span class="label label-success">ADMIN</span>
				发表于
				<span class="label label-success">4小时前</span>
			</div>
		</a>
	</div>
	<div class="body">
		你就是个傻逼
	</div>
	<div class="action clearfix">
		<div class="btn-group pull-right">
			<button class="btn btn-mini"><i class="icon-thumbs-up"></i> 赞</button>
			<button class="btn btn-mini">举报</button>
		</div>
	</div>
	<?php
	$random = rand(0, 10);
	if ($random > 5)
	{
	?>
	<div class="foot">
		<ul class="unstyled">
			<li><strong>ADMIN</strong>： 人贱自有天收。</li>
			<li><strong>ADMIN</strong>： 人贱自有天收。</li>
			<li><strong>ADMIN</strong>： 人贱自有天收。</li>
		</ul>
	</div>
	<?php
	}
	?>
</div>
