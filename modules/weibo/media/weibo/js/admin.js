/**
 * 微博管理页面所有用到的特定JS
 *
 * @author	YwiSax
 * @date	20131113
 */

/**
 * 微博管理页面的popover，主要用来显示用户的头像
 */
var AdminWeiboPopoverHandler = function () {
	$('a[rel=popover]').popover({
		html: true,
		trigger: 'hover',
		content: function () {
			return '<img width="120" height="120" src="'+$(this).data('img') + '" />';
		}
	});
}
AdminWeiboPopoverHandler();

/**
 * 删除微博处理器
 */
var AdminWeiboDeleteHandler = function () {
	$('.delete-weibo-btn').click(function(){
		var current = $(this);
		bootbox.confirm($('#admin-weibo-delete-table').data('delete-title'), function(result) {                
			if (result === null) {
				//alert('no days');
			} else {
				// 换成ajax方法可能会好点
				$.post($('#admin-weibo-delete-table').data('delete-callback'), {
					id: current.data('id'),
					async: 1
				}, function(){
					window.location.href = '?r='+Math.random();
				});
			}
		});
		return false;
	});
}
AdminWeiboDeleteHandler();

/**
 * 禁用和解禁用户操作
 */
var AdminWeiboUserHandler = function () {
	$('.release-user-button').popover({
		html: true,
		trigger: 'hover',
		title: '',
		content: function () {
			return $(this).data('title') + '<br/>' + $(this).data('operator') + '<br/>' + $(this).data('reason');
		}
	});
	$('.ban-user-button').click(function(){
		var url = $(this).data('url');
		bootbox.prompt("Please select the ban days.", function(result) {
			if (result === null) {
				//alert('no days');
			} else {
				$.post(url, {day: result}, function(){
					window.location.href = '?r='+Math.random();
				});
			}
		});
		return false;
	});
	$('.release-user-button').click(function(){
		var url = $(this).data('url');
		bootbox.confirm("Are you sure to release the user ?", function(result) {
			if (result) {
				$.get(url, function(){
					window.location.href = '?r='+Math.random();
				});
			}
		});
		return false;
	});
}
AdminWeiboUserHandler();

