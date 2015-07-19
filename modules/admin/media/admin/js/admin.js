/**
 * popover初始化
 */
var PopoverInitHandler = function () {
	$('a[rel="popover"]').popover();
	$('button[rel="popover"]').popover();
}
PopoverInitHandler();

/**
 * 添加模板
 */
var EditableTableAddColumnHandler = function () {
	$('.editable-table .add-column').off('click');
	$('.editable-table .add-column').on('click', function() {
		var table = $(this).closest('.editable-table');
		var template = table.find('.template').clone().removeClass('template');
		var editable = template.find('.editable');
		editable
			.editable('setValue', null)
			.editable('option', 'pk', null)
			.removeClass('editable-unsaved')
			.on('save.newitem', function() {
				var that = this;
				setTimeout(function() {
					$(that).closest('td').next().find('.editable').editable('show');
				}, 200);
			});
			table.find('tbody').append(template);
		EditableTableNewColumnSubmitHandler();
		EditableTableNewColumnDeleteHandler();
		return false;
	});
}
EditableTableAddColumnHandler();

/**
 * 提交数据
 */
var EditableTableNewColumnSubmitHandler = function () {
	$('.editable-table .new-item .submit').off('click');
	$('.editable-table .new-item .submit').on('click', function(){
		var tr = $(this).closest('.new-item');
		var table = $(this).closest('.editable-table');
		
		var data = {};
		if (table.data('append')) {
			data = table.data('append');
		}
		
		tr.find('.editable').editable('submit', {
			url: table.data('newitem-callback'),
			ajaxOptions: {
				dataType: 'json' //assuming json response
			},
			data: data,
			success: function(data, config) {
				if(data && data.id) {
					//record created, response like {"id": 2}
					
					//set pk
					$(this).editable('option', 'pk', data.id);
					tr.find('.id').html(data.id);

					//remove unsaved class
					$(this).removeClass('editable-unsaved');

					//show messages
					if (data.msg) {
						msg = data.msg;
					} else {
						var msg = '创建成功！';
					}
					bootbox.alert(msg);

					tr.find('.delete').data('id', data.id);
					tr.find('.submit').remove();
					
					$(this).off('save.newitem');
				} else if(data && data.errors) { 
					//server-side validation error, response like {"errors": {"username": "username already exist"} }
					config.error.call(this, data.errors);
				}
			},
			error: function(errors) {
				var msg = '';
				if(errors && errors.responseText) {
					//ajax error, errors = xhr object
					msg = errors.responseText;
				} else {
					//validation error (client-side or server-side)
					$.each(errors, function(k, v) { msg += k+": "+v+"<br>"; });
				}
				bootbox.alert(msg);
           }
		});
		EditableTableNewColumnDeleteHandler();
		return false;
	});
}

/**
 * 删除单行记录
 */
EditableTableNewColumnDeleteHandler = function () {
	$('.editable-table tr .delete').off('click');
	$('.editable-table tr .delete').on('click', function(){
		var id = $(this).data('id');
		var tr = $(this).closest('tr');
		var table = $(this).closest('.editable-table');
		// 有id的话，提交到远程
		if (id) {
			var callback = table.data('delete-callback');
			var title = table.data('delete-title');
			bootbox.confirm(title, function(result){
				if (result) {
					$.post(callback, {
						id: id
					}, function(){
						tr.remove();
					});
				}
			});
		} else {
			tr.remove();
		}
		return false;
	});
}
EditableTableNewColumnDeleteHandler();

var EditableTableInitHandler = function () {
	$('.editable-table .editable').editable();
}
EditableTableInitHandler();

