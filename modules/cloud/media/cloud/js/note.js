bootbox.setLocale('zh_CN');

// 加载左侧笔记列表
var InitCloudNoteNavList = function () {
	var ul = $('#note-list-nav');
	var callback = ul.data('callback');
	$.get(callback, function(result){
		ul.html(result);
	});
}
InitCloudNoteNavList();

$('#note-add').click(function(){
	$('#note-title').val('');
	$('#editor').html('');
	$('#note-save').data('id', '');
	$('#note-delete').data('id', '');
	return false;
});

$('#note-save').on('click', function(){
	var id = $(this).data('id');
	var callback = $(this).data('callback');
	bootbox.prompt('请输入密码（记得保存）', function(result){
		console.log("密码："+result);
		// result是密码

		var title = $('#note-title').val();
		console.log('标题：'+title);

		var txt = $('#editor').html();
		console.log("文本："+txt);

		GibberishAES.size(192);
		var enc_txt = GibberishAES.enc(txt, result);
		//$('#debug').html(enc_txt);

		$.post(callback, {
			id: id,
			title: title,
			content: enc_txt
		}, function(result){
			InitCloudNoteNavList();
			//bootbox.alert('笔记保存成功！');
			console.log(result);
		});
	});
	return false;
});

$('#note-delete').on('click', function(){
	var callback = $(this).data('callback');
	var id = $(this).data('id');
	bootbox.confirm('你确定要删除该笔记吗？不可恢复', function(result){
		if (result) {
			$.post(callback, {
				id: id
			});
			$('#cloud-note-'+id).remove();
			$('#note-add').click();
		}
		//console.log(result);
	});
	return false;
});

var GetCloudNote = function(id) {
	var callback = $('#note-list-nav').data('get-callback');
	console.log(callback);
	$.post(callback, {
		id: id,
		timestamp: new Date().getTime()
	}, function(data){
		console.log(data);

		$('#note-title').val(data.title);
		$('#note-save').data('id', data.id);
		$('#note-delete').data('id', data.id);

		bootbox.prompt('请输入密码', function(result){
			if (result === null) {
				$('#editor').html(data.content);
			} else {
				GibberishAES.size(192);
				var content = data.content;
				try {
					content = GibberishAES.dec(content, result);
				} catch (error) {
					console.log(error);
					content = data.content;
				}
				$('#editor').html(content);
			}
		});
	});
	return false;
};

