jQuery(document).ready(function($) {
	
	$("#SaveBtn").click( function() {
		var scis_type = $('#type').val();
		var scis_cname = $('#code_name').val();
		var scis_cdata = $('#code_data').val();
		var data = {
			action: 'scis_process',			
			post_type: scis_type,
			post_cname: scis_cname,
			post_cdata: scis_cdata
			      
		};
		
	 	$.post(scis_ajax_script.ajaxurl, data, function(response) {
			
			$('.display-message').html(response);			
			$('.scis_form_new_code')[0].reset();
			location.reload();	
	 	});
	 	return false;
	});

	$(".DeleteBtn").click( function(){

		var scis_id = $(this).attr("value");

		var data = {
			action: 'scis_process',
			post_type: 'delete',
			post_id: scis_id
		};

		$.post(scis_ajax_script.ajaxurl, data, function(response) {
			
			alert(response);
			location.reload();	
			
	 	});
	 	return false;
	});

	$(".EditBtn").click( function(){

		var scis_id = $(this).attr("value");
		
		$("#dialog-edit-message").html('');

		var data = {
			action: 'scis_process',
			post_type: 'edit',
			post_id: scis_id
		};

		$.post(scis_ajax_script.ajaxurl, data, function(response) {
			
			$(".display-message-modify").html(response);
	 	});

		return false;
	});

	$('body').on('click', '#ModifyBtn', function (){

		var scis_type = $('#mtype').val();
		var scis_id = $('#mid').val();
		var scis_cname = $('#mcode_name').val();
		var scis_cdata = $('#mcode_data').val();

		var data = {
			action: 'scis_process',
			post_id: scis_id,			
			post_type: scis_type,
			post_cname: scis_cname,
			post_cdata: scis_cdata
			      
		};
		
	 	$.post(scis_ajax_script.ajaxurl, data, function(response) {
			
			$('#dialog-edit-message').html(response);
			location.reload();	
	 	});
	 	return false;

	});
});