// WP Butler
jQuery( function($) {

	Mousetrap.bind( 'shift+alt+b', function(e) {
		$( "#butler-dialog" ).dialog({
			modal: true,
			closeOnEscape: true
		});

		$( "#wpButlerField" ).focus();

		return false;
	}, 'keyup' );

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
