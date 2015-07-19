var window_resize_handler = function (width) {
	if (width <= 480) {
		console.log('Responsive Width: '+width);
		width = width+10;
		console.log('New Width: '+width);
		$('#quickpost').css('width', width+'px').css('margin-left', '-'+(width/2)+'px');
		
		var left_btn_width = $('#quickpost .home').outerWidth();
		console.log(left_btn_width);
		var right_btn_width = $('#quickpost .user').outerWidth();
		console.log(right_btn_width);
		var new_middle_width = width - left_btn_width - right_btn_width;
		$('#quickpost .post').css('width', new_middle_width+'px');
	}
}
window_resize_handler( $(window).width() );
$(window).resize(function() {
	window_resize_handler( $(window).width() );
});
