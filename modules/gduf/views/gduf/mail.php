<?php
Page::style('gduf/css/mail.css');
Page::style('gduf/css/mail-responsive.css');
Page::script('bootbox/bootbox.js');
Page::script('gduf/js/mail.js');
?>
<script>
	var CURRENT_JSESSIONID = '<?php echo $JSESSIONID ?>';
</script>
<?php include Kohana::find_file('views', 'gduf/mail/login') ?>
<?php include Kohana::find_file('views', 'gduf/mail/body') ?>
<?php include Kohana::find_file('views', 'gduf/mail/read') ?>
<?php include Kohana::find_file('views', 'gduf/mail/send') ?>

<div id="dump">
</div>
