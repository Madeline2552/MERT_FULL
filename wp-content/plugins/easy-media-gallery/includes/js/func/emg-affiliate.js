jQuery(document).ready(function($) {
	
	jQuery('#emg-aff').bind('click', function () {
		
		var email = jQuery('#emg_aff_email').val();
		var sec = jQuery(this).data('nonce');
		var cmd = jQuery(this).data('cmd');
		var elmt = jQuery(this);
		
		if ( email != '' ) {
	
			emg_get_aff_ajax( cmd, email, sec, elmt );
		
			} else {
			
				alert('Please input your Account Email or Payment Email!');
			
				return false;
			
				}
		
		return false;
		
		});

		
	function emg_get_aff_ajax( cmd, email, sec, elmt ) {
	
		jQuery('#loader').addClass('button_loading');
		jQuery(elmt).attr('disabled','disabled');
	
		dat = {};
		dat['eml'] = email;
		dat['security'] = sec;
		dat['command'] = cmd;
		dat['action'] = 'emg_get_aff_data';

		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			dataType: 'json',
			data: dat,
		
			success: function(response) {
				
				if (response.status == true ) {
					
					emg_restore_registered(elmt, response.aff_name, email);
					
					}
					
					else if (response.status == 'disconnected' ) {	
					
						jQuery('#emg_aff_email').val('');
						emg_restore_not_reg(elmt);
					
						} else {
						
							emg_restore_not_reg(elmt);
							alert('Oops. The email address you entered is not valid!');
					
							}
			
			// end success-		
			}
			
		// end ajax
	});
	
}


	function emg_restore_registered(elmt, affname, affemail ) {
	
		jQuery(elmt).removeAttr('disabled');
		jQuery('#loader').removeClass('button_loading');
		jQuery('#is-status').text('Connected');
		jQuery(elmt).data('cmd', 'emg_affiliate_dis').val('Disconnect');
		jQuery('#emg-not-yet').hide();
		jQuery('#emg-aff-registered').fadeIn(1000);
		jQuery('#emg-aff-holder').text('Hi, '+affname+' ( '+affemail+' )');
		
	
	}

	function emg_restore_not_reg(elmt) {
	
		jQuery(elmt).removeAttr('disabled');
		jQuery('#loader').removeClass('button_loading');
		jQuery('#is-status').text('');
		jQuery(elmt).data('cmd', 'emg_affiliate_con').val('Connect');	
		jQuery('#emg-not-yet').show();
		jQuery('#emg-aff-holder').text('');
		jQuery('#emg-aff-registered').hide();
	
	}

		
	
});