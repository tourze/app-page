var AdminAuthFieldTableLoginColumnHandler = function () {
	$('#admin-auth-field-table .actions .login').off('click');
	$('#admin-auth-field-table .actions .login').on('click', function(){
		var current = $(this);
		var callback = current.closest('table').data('set-login-callback');
		var id = current.data('id');
		var value = current.data('value');
		var class_name = current.data('class');
		var new_value = (value == 1) ? 0 : 1;

		$.post(callback, {
			id: id,
			value: new_value
		}, function(){
			value = new_value;
		});

		current.data('value', new_value);
		if (new_value == 0) {
			current.removeClass(class_name);
		} else {
			current.addClass(class_name);
		}
		
		return false;
	});
	
}
AdminAuthFieldTableLoginColumnHandler();

