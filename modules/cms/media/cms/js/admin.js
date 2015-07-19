$('#admin-cms-field-list li a').on('click', function(){
	//console.log('ID:' + $(this).data('id'));
	$('#field-id').val( $(this).data('id') );
	$('#field-name').val( $(this).data('name') );
	$('#field-title').val( $(this).data('title') );
	$('#field-order').val( $(this).data('order') );
	$('#field-description').val( $(this).data('description') );

	var type = $(this).data('type');
	$('#field-type').val(type).change();

	var config = $(this).data('config');

	window.config = config;
	//console.log(typeof config.default);

	if (type == 0 || type == 1) {
		if (!config || !('default' in config)) {
			$('#field-type-config-'+type+'-default').val('');
		} else {
			$('#field-type-config-'+type+'-default').val(config.default);
		}
		if (!config || !('length' in config)) {
			$('#field-type-config-'+type+'-length').val('');
		} else {
			$('#field-type-config-'+type+'-length').val(config.length);
		}
		if (config && ('wysiwyg' in config)) {
			if (config.wysiwyg) {
				$('#field-type-config-'+type+'-wysiwyg').prop('checked', true);
			} else {
				$('#field-type-config-'+type+'-wysiwyg').prop('checked', false);
			}
		} else {
			$('#field-type-config-'+type+'-wysiwyg').prop('checked', false);
		}
	} else if (type == 5 || type == 4) {
		console.log(config);
		$('#field-type-config-'+type+' tbody').html('');
		if (config) {
			for (i in config.name) {
				if (config.name[i]) {
					var template = $('#field-type-config-'+type+' .template').clone().removeClass('template');
					template.find('.name-input').val(config.name[i]);
					template.find('.value-input').val(config.value[i]);
					template.find('.default-input').val(config.default[i]);
					console.log(i+':'+config.default[i]);
					if (config.default[i] == 1) {
						template.find('.default').addClass('btn-info');
					}
					$('#field-type-config-'+type+' tbody').append(template);
				}
			}
			CMSAdminFieldRadioToggleDefaultHandler();
			CMSAdminFieldRadioDeleteHandler();
			CMSAdminFieldCheckboxDeleteHandler();
			CMSAdminFieldCheckboxToggleDefaultHandler();
		}
	} else if (type == 6) {
		if (config && ('limit' in config)) {
			$('#field-type-config-6-limit').val(config.limit);
		} else {
			$('#field-type-config-6-limit').val(1);
		}
	} else {
	}
	
	$('#admin-cms-field-form-actions .delete').prop('disabled', false).data('id', $(this).data('id'));
	return false;
});
$('#admin-cms-field-form-actions .clear').click(function(){
	$('#field-id').val('');
	$('#field-name').val('');
	$('#field-title').val('');
	$('#field-order').val(0);
	$('#field-description').val('');
	$('#field-type').val(0).change();
	$('#admin-cms-field-form-actions .delete').prop('disabled', true);
	$('#field-type-config-0-default').val('');
	return false;
});
$('#admin-cms-field-form-actions .delete').on('click', function(){
	var callback = $(this).data('callback');
	var title = $(this).data('title');
	var id = $(this).data('id');
	bootbox.confirm(title, function(result){
		console.log(result);
		if (result) {
			$.post(callback, {
				id: id
			}, function(){
				$('#admin-cms-field-list-item-'+id).remove();
			});
		}
		//return false;
	});
	return false;
});

$('#field-type').on('change', function(){
	var val = $(this).val();
	$('.field-type-config').hide();
	$('#field-type-config-'+val).show();
});

/** Checkbox */
var CMSAdminFieldCheckboxAddHandler = function () {
	$('#field-type-config-4 .add-new').on('click', function(){
		var template = $('#field-type-config-4 .template').clone().removeClass('template');
		console.log(template);
		$('#field-type-config-4 tbody').append(template);
		CMSAdminFieldCheckboxDeleteHandler();
		CMSAdminFieldCheckboxToggleDefaultHandler();
		return false;
	});
}
CMSAdminFieldCheckboxAddHandler();
var CMSAdminFieldCheckboxToggleDefaultHandler = function () {
	$('#field-type-config-4 tbody .default').on('click', function(){
		var input = $(this).next().next();
		if (input.val() == 0) {
			$(this).addClass('btn-info');
			input.val(1);
		} else {
			$(this).removeClass('btn-info');
			input.val(0);
		}
		return false;
	});
}
var CMSAdminFieldCheckboxDeleteHandler = function () {
	$('#field-type-config-4 tbody .delete').on('click', function(){
		$(this).closest('tr').remove();
		return false;
	});
}

/** Radio */
var CMSAdminFieldRadioAddHandler = function () {
	$('#field-type-config-5 .add-new').on('click', function(){
		var template = $('#field-type-config-5 .template').clone().removeClass('template');
		//console.log(template);
		$('#field-type-config-5 tbody').append(template);
		CMSAdminFieldRadioToggleDefaultHandler();
		CMSAdminFieldRadioDeleteHandler();
		return false;
	});
}
CMSAdminFieldRadioAddHandler();
var CMSAdminFieldRadioToggleDefaultHandler = function () {
	$('#field-type-config-5 tbody .default').click(function(){
		$('#field-type-config-5 tbody .default').removeClass('btn-info');
		$('#field-type-config-5 tbody .default-input').val('0');
		$(this).addClass('btn-info');
		$(this).next().next().val('1');
		return false;
	});
}
var CMSAdminFieldRadioDeleteHandler = function () {
	$('#field-type-config-5 tbody .delete').on('click', function(){
		$(this).closest('tr').remove();
		return false;
	});
}




/*************************************
 ************** 模型部分 *************
*************************************/
var CMSAdminModelListClickHandler = function () {
	$('#admin-cms-model-list li a').on('click', function(){
		var model_id = $(this).data('id');
		var model_name = $(this).data('name');
		var model_title = $(this).data('title');
		var model_order = $(this).data('order');
		var model_description = $(this).data('description');
		var model_fields = $(this).data('fields');
		//console.log(model_fields);

		$('#model-id').val(model_id);
		$('#model-name').val(model_name);
		$('#model-title').val(model_title);
		$('#model-order').val(model_order);
		$('#model-description').val(model_description);
		
		//$('#admin-cms-model-form-columns').html('');
		$('.admin-cms-model-form-fields-item').prop('checked', false);
		for (i in model_fields) {
			//console.log(model_fields[i]);
			$('#admin-cms-model-form-fields-item-'+model_fields[i]).prop('checked', true);
		}

		return false;
	});
}
CMSAdminModelListClickHandler();

var CMSAdminModelFormClearHandler = function(){
	$('#admin-cms-model-form-actions .clear').on('click', function(){
		$('#model-id').val('');
		$('#model-name').val('');
		$('#model-title').val('');
		$('#model-order').val(0);
		$('#model-description').val('');
		$('#admin-cms-model-form-columns').html('');
		return false;
	});
}
CMSAdminModelFormClearHandler();

var CMSAdminModelFormDeleteHandler = function () {
	$('#admin-cms-model-form-actions .delete').on('click', function(){
		var model_id = $('#model-id').val();
		var callback = $(this).data('callback');
		console.log('DELETE: '+model_id);
		bootbox.confirm($(this).data('title'), function(result){
			if (result) {
				$.post(callback, {
					id: model_id
				}, function(){
					$('#admin-cms-model-list-item-'+model_id).remove();
					$('#admin-cms-model-form-actions .clear').click();
				});
			}
		});
		return false;
	});
}
CMSAdminModelFormDeleteHandler();

var CMSAdminModelFormAddColumnHandler = function () {
	$('#admin-cms-model-form-add-new .add-new').on('click', function(){
		var callback = $(this).data('callback');
		var model_id = $('#model-id').val();
		$.post(callback, {
			id: model_id
		}, function(html){
			$('#admin-cms-model-form-columns').append(html);
			CMSAdminModelFormColumnSelectHandler();
			CMSAdminModelFormColumnDeleteHandler();
		});
		return false;
	});
}
CMSAdminModelFormAddColumnHandler();

var CMSAdminModelFormColumnSelectHandler = function () {
	$('.admin-cms-model-field-select').on('change', function(){
		var type = $(this).val();
		var controls = $(this).parent().next();
		controls.find('.field-type-config').hide().each(function(){
			var id = $(this).data('id');
			if (id == type) {
				$(this).show();
			}
		});
	});
}
CMSAdminModelFormColumnSelectHandler();

var CMSAdminModelFormColumnDeleteHandler = function () {
	$('.admin-cms-model-field-select-control .delete').off('click');
	$('.admin-cms-model-field-select-control .delete').on('click', function(){
		var current = $(this);
		bootbox.confirm($(this).data('title'), function(result){
			if (result) {
				current.closest('.control-group').remove();
			}
		});
		return false;
	});
}
CMSAdminModelFormColumnDeleteHandler();


