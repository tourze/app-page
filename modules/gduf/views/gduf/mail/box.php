<?php echo isset($pagination) ? $pagination : '' ?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th width="28">
			</th>
			<th width="100" class="hidden-480"><?php echo ($foldertype == 2) ? '收件人' : '发件人' ?></th>
			<th>主题</th>
			<th width="90" class="hidden-480">日期</th>
			<th class="hidden-print hidden-480" width="36">附件</th>
		</tr>
	</thead>
	<tbody>
	<?php if ($mails['list']): ?>
	<?php foreach ($mails['list'] AS $mail): ?>
	<?php
	// 监测是否为未读邮件
	$sender = (trim($mail['YJFJDZ']) == '-----&nbsp;') ? $mail['YJYG'] : $mail['YJFJDZ'];
	$unread = strpos($sender, '</strong>');
	$sender = trim(strip_tags($sender));
	$sender = trim(str_replace('&nbsp;', ' ', $sender));
	$mail['subject'] = htmlspecialchars($mail['subject']);
	?>
		<tr class="mail-tr<?php if ($unread) { echo ' unread'; } ?>" id="mail-<?php echo $mail['id'] ?>" data-id="<?php echo $mail['id'] ?>">
			<td class="status">
				<label for="checkbox-<?php echo $mail['id'] ?>">
					<!--<input type="checkbox" id="checkbox-<?php echo $mail['id'] ?>" name="YJID_<?php echo $mail['id'] ?>" value="<?php echo $mail['id'] ?>">-->
					<img src="<?php echo Media::url('gduf/img/email-'.($unread ? 'ok' : 'no').'.png') ?>" />
				</label>
			</td>
			<td class="hidden-480 sender" title="<?php echo $sender; ?>"><?php echo Text::limit_chars($sender, 8); ?></td>
			<td class="title">
				<a class="read-mail" title="<?php echo $mail['subject'] ?>" data-personid="<?php echo $mail['personId'] ?>" data-id="<?php echo $mail['id'] ?>" data-toggle="modal" data-backdrop="false" data-target="#mail-modal" href="<?php echo Route::url('gduf-mail-action', array('action' => 'read')) ?>?foldertype=<?php echo $mail['foldertype'] ?>&id=<?php echo $mail['id'] ?>&page=<?php echo $mail['page'] ?>&personId=<?php echo $mail['personId'] ?>&reply=<?php echo $mail['reply'] ?>&transmit=<?php echo $mail['transmit'] ?>&readFlag=<?php echo $mail['read'] ?>"><?php echo $mail['subject'] ?></a>
			</td>
			<td class="hidden-480 dateline" title="<?php echo $mail['YJFSSJ'] ?>"><?php echo UTF8::substr($mail['YJFSSJ'], 0, 10) ?></td>
			<td class="hidden-print hidden-480 download"<?php if (intval($mail['size']) > 0) { ?> title="大小：<?php echo $mail['size'] ?>K"<?php } ?>><?php echo $mail['downlink'] ?></td>
		</tr>
	<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="5">列表为空</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
<?php echo isset($pagination) ? $pagination : '' ?>
