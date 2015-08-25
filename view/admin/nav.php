<div id="head" class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#admin-nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="<?php echo Route::url('page-admin', array('controller' => 'Entry')) ?>">LZP</a>
			<div id="admin-nav-collapse" class="nav-collapse collapse">
				<ul id="navigation" class="nav">
				<?php if (Kohana::$config->load('admin.navigation')): ?>
				<?php
				foreach (($navs = array_reverse(Kohana::$config->load('admin.navigation'))) AS $title => $nav_data)
				{
					//print_r($nav_data);
					$is_active = FALSE;
					$in_route = FALSE;
					if (isset($nav_data['admin_route']) AND Route::name(Request::current()->route()) == $nav_data['admin_route'])
					{
						$in_route = TRUE;
					}
					//echo $in_route ? 'T' : 'F';
					if ($in_route AND in_array(Request::current()->controller(), $nav_data['admin_controller']))
					{
						$is_active = TRUE;
					}
				?>
					<li class="dropdown<?php if ($is_active) { echo ' active'; } ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $title ?></a>
						<ul class="dropdown-menu" data-url="<?php echo Request::current()->url() ?>">
						<?php foreach ($nav_data['links'] AS $title => $link): ?>
							<li<?php if (Request::current()->url() == $link) { echo ' class="active"'; } ?>><?php echo HTML::anchor($link, $title) ?></li>
						<?php endforeach; ?>
						</ul>
					</li>
				<?php
				}
				?>
				<?php endif; ?>
				</ul>
				<ul id="auth" class="nav pull-right">
					<li><a href="<?php echo URL::base() ?>" target="_blank"><?php echo __('Visit Site') ?></a></li>
					<?php if (isset($user) AND $user): ?>
					<li><a href="#"><?php echo __('Logged in as :user', array(':user' => $user)); ?></a></li>
					<li><?php echo HTML::anchor( Route::url('admin', array('action' => 'logout')), __('Logout') ) ?></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
