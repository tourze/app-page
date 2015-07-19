$(document).ready(function(){
	$("#pagetree").treeview({
		animated:	"fast",
		collapsed:	true,
		url:		$('#pagetree').data('source'),
		ajax: {
			data: {
				"timestamp": function() {
					return (new Date()).valueOf();
				}
			},
			type: "post"
		}
	});
	//$("#pagetree-loading").hide();
});

