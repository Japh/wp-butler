// WP Butler
jQuery( function($) {

	$.keyStroke( 66, function() {
		$( "#butler-dialog" ).dialog({
			modal: true,
			closeOnEscape: true
		});

		$( "#wpButlerField" ).focus();
	}, { modKeys: [ 'shiftKey', 'altKey' ] } );

	$( "#butler-close-dialog" ).click(function(e) {
		e.preventDefault();
		$( "#butler-dialog" ).dialog( "close" );
	});

	$( "#wpButlerField" ).autocomplete({
		source: ajaxurl + '?action=wp_butler_actions&_nonce=' + $.trim( $('#wp-butler-nonce').val() ),
		select: function( event , ui ) {
			window.location.href = ui.item.url;
			return false;
		}
	});
});
