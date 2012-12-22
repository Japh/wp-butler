//WP Butler
jQuery(function($) {
        var wpButlerActions = [
            { label :"Add Page" , value: "post-new.php?post_type=page"},
            { label :"Add Post" , value: "post-new.php?post_type=post"},
        ];
        $( "#wpButlerField" ).autocomplete({
            //source: '../wp-content/plugins/wp-butler/wpButlerActions.php',
            source: wpButlerActions,
            select: function( event , ui ) {
                window.location.href = ui.item.value;
                return false;
            }
        });
});