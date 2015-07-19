$(function(){

	$(window).scroll(function(){
		// 添加一个类表明当前正在滚动
		if ($(this).scrollTop() > 100) {
			$(".navbar.navbar-fixed-top").addClass("scroll");
		} else {
			$(".navbar.navbar-fixed-top").removeClass("scroll");
		}
	});

	// 加载完毕后在底部加载一个空的div
	var body_loading_init = function() {
		$('body').append('<div id="loading"></div>');
	}
	body_loading_init();

	// 登陆回调
	var auth_callback = $('#auth-nav').data('callback');
	if (auth_callback)
	{
		$('#auth-nav').hide();
		$.get(auth_callback, function(data){
			$('#auth-nav').html(data).fadeIn();
			
			// 注册按钮，ajax啊
			$('#nav-register a').on('click', function(){
				var callback = $(this).data('callback');
				console.log(callback);
				$.get(callback, function(data) {
					$(data).modal();
				});
				return false;
			});
	
			// 登陆按钮，ajax啊
			$('#nav-login a').on('click', function(){
				var callback = $(this).data('callback');
				console.log(callback);
				$.get(callback, function(data) {
					$(data).modal();
				});
				return false;
			});
			console.log('Callback OK');
		});
	}

	$("#loading").ajaxStart(function(){
		$(this).fadeIn();
	});

	$("#loading").ajaxStop(function(){
		$(this).fadeOut();
	});

	$('.avatar-block').tooltip();
	$('a[rel=popover], button[rel=popover]').popover()
});

