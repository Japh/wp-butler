// WP Butler
jQuery( function($) {
	
	// keyboard shortcut to view dialog
	$.keyStroke( 66, function() {
		$( "#wp-butler-dialog" ).dialog({
			modal: true,
			closeOnEscape: true
		});
	
		$( "#wp-butler-field" ).focus();
	}, { modKeys: [ 'shiftKey', 'altKey' ] } );
	
	// click on button in admin bar to view dialog
	$( '#wp-admin-bar-wp-butler' ).click( function() {
		$( "#wp-butler-dialog" ).dialog( {
			modal: true,
			closeOnEscape: true
		});
		
		$( "#wp-butler-field" ).focus();
	} );
	
	$( "#butler-close-dialog" ).click(function(e) {
		e.preventDefault();
		$( "#butler-dialog" ).dialog( "close" );
	});

	$( "#wp-butler-field" ).autocomplete({
		source: ajaxurl + '?action=wp_butler_actions&_nonce=' + $.trim( $('#wp-butler-nonce').val() ) + '&_context=' + $.trim( $('#wp-butler-context').val() ),
		select: function( event , ui ) {
			window.location.href = ui.item.url;
			return false;
		}
	});

});
