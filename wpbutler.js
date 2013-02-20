// WP Butler
jQuery( function($) {
	var openButler = function() {
		$( "#wp-butler-dialog" ).dialog({
			modal: true,
			closeOnEscape: true,
			width: 420
		}).parent().addClass('butler-ui-widget');
	
		$( "#wp-butler-field" ).focus();
	};
	
	// keyboard shortcut to view dialog
	$.keyStroke( 66, openButler, { modKeys: [ 'shiftKey', 'altKey' ] } );
	
	// click on button in admin bar to view dialog
	$( '#wp-admin-bar-wp-butler' ).click( openButler );
	
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
