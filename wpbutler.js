//WP Butler
jQuery(function($) {
        var wpButlerActions = [
            { label :"Add Page" , value: "post-new.php?post_type=page"},
            { label :"Add Post" , value: "post-new.php?post_type=post"},
            { label :"New Page" , value: "post-new.php?post_type=page"},
            { label :"New Post" , value: "post-new.php?post_type=post"},
            { label :"Edit Posts" , value: "edit.php"},
            { label :"Edit Pages" , value: "edit.php?post_type=page"},
            { label :"View All Posts" , value: "edit.php"},
            { label :"View All Pages" , value: "edit.php?post_type=page"},
            { label :"Media Library" , value: "upload.php"},
            { label :"Add Media" , value: "media-new.php"},
            { label :"Upload Media" , value: "media-new.php"},
            { label :"New Media Item" , value: "media-new.php"},
            { label :"Approve Comments" , value: "edit-comments.php"},
            { label :"View Comments" , value: "edit-comments.php"},
            { label :"Change Theme" , value: "themes.php"},
            { label :"Install Theme" , value: "theme-install.php"},
            { label :"Add Widgets" , value: "widgets.php"},
            { label :"Edit Widgets" , value: "widgets.php"},
            { label :"Add Menu" , value: "nav-menus.php"},
            { label :"Edit Menus" , value: "nav-menus.php"},
            { label :"Edit Settings" , value: "options-general.php"},
            { label :"Edit Permalinks" , value: "options-permalink.php"},
            { label :"Install Plugin" , value: "plugin-install.php"},
            { label :"View Plugins" , value: "plugins.php"},
            { label :"View Users" , value: "users.php"},
            { label :"Add New User" , value: "user-new.php"},
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