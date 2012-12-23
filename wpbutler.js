// WP Butler
jQuery( function($) {
	$( "#wpButlerField" ).autocomplete({
		source: ajaxurl + '?action=wp_butler_actions&_nonce=' + $.trim( $('#wp-butler-nonce').val() ),
		select: function( event , ui ) {
			window.location.href = ui.item.url;
			return false;
		}
	});
});
