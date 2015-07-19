<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title><?php echo __('Admin Login') ?></title>
	<link type="text/css" href="<?php echo Media::url('bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" />
	<link type="text/css" href="<?php echo Media::url('bootstrap/css/bootstrap-responsive.min.css') ?>" rel="stylesheet" />
	<link type="text/css" href="<?php echo Media::url('css/style.css') ?>" rel="stylesheet" />
	<link type="text/css" href="<?php echo Media::url('css/style-responsive.css') ?>" rel="stylesheet" />
</head>
<body>
	<div class="container">
		<div class="row-fluid">
			<div class="offset3 span5">
				<form class="form-horizontal" method="post">
					<legend><?php echo __('Login') ?></legend>
					<div class="control-group<?php if (isset($errors['username'])): ?> error<?php endif; ?>">
						<label class="control-label" for="admin-login-username"><?php echo __('Username') ?></label>
						<div class="controls">
							<input type="text" id="admin-login-username" class="span12" placeholder="<?php echo __('Username') ?>" name="username" value="<?php echo $user->username ?>" />
							<?php if (isset($errors['username'])): ?><br /><span class="help-inline"><?php echo $errors['username'] ?></span><?php endif; ?>
						</div>
					</div>
					<div class="control-group<?php if (isset($errors['password'])): ?> error<?php endif; ?>">
						<label class="control-label" for="admin-login-password"><?php echo __('Password') ?></label>
						<div class="controls">
							<input type="password" id="admin-login-password" class="span12" placeholder="<?php echo __('Password') ?>" name="password" />
							<?php if (isset($errors['password'])): ?><br /><span class="help-inline"><?php echo $errors['password'] ?></span><?php endif; ?>
						</div>
					</div>
					<div class="control-group<?php if (isset($errors['captcha'])): ?> error<?php endif; ?>">
						<div class="control-label">
							<label id="captcha-label" for="captcha-input"><?php echo __('Captcha Code:') ?></label>
						</div>
						<div class="controls">
							<input id="captcha-input" type="text" maxlength="4" name="captcha" class="captcha-input"  /><?php echo Captcha::instance() ?>
							<?php if (isset($errors['captcha'])): ?><br /><span class="help-inline"><?php echo $errors['captcha'] ?></span><?php endif; ?>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-primary btn-large"><?php echo __('Login') ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
