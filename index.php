<?php
/**
 * @package WP-Butler
 * @version 1.0
 */
/*
	/*
	Plugin Name: WP Butler
	Plugin URI: http://www.jordesign.com/wp-butler
	Description: WP Butler brings you what you need in the Wordpress Admin. An autocomplete menu to let you jump to all the common tasks you may need to perform.
	Author: Jordan Gillman
	Version: 1.0
	Author URI: http://www.jordesign.com
	*/
	
	add_action('wp_dashboard_setup', 'jg_butler_setup');
	 
	function jg_butler_setup() {
	    global $wp_meta_boxes;
	wp_add_dashboard_widget('wp_butler', 'WP Butler', 'jg_wp_butler');
	}
	
	function jg_wp_butler() { 
	echo '<p style="padding: 5px 0px; margin:0 0 10px 0; color: #8F8F8F;font-size: 14px;border-bottom:1px solid #ddd;display:inline-block;">What would you like to do?</p>';
	echo '<form id="wpButler"><input type="text" placeholder="just start typing..." style="width:90%; font-size:16px;padding:4px 0 6px 10px"id="wpButlerField"><input type="hidden" id="wp-butler-nonce" name="wp-butler-nonce" value="' . wp_create_nonce( 'wp_butler_nonce' ) . '" /></form>';  
	}
	
	
	
// Enqueue Jquery UI Autocomplete
function jg_add_autocomplete() {
    if(is_admin()) {
        wp_register_script('wpbutler', plugins_url('wpbutler.js', __FILE__), array('jquery'), '1.0', true);
        wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');
        wp_enqueue_script( 'wpbutler' );  
    }
}; 
 
add_action('admin_enqueue_scripts', 'jg_add_autocomplete');

// Enqueue Jquery UI Autocomplete
function wp_butler_actions() {
	$return = array();
	$term = $_REQUEST['term'];
	$nonce = $_REQUEST['_nonce'];

    if ( is_admin() && wp_verify_nonce( $nonce, 'wp_butler_nonce' ) ) {
		$butler_actions = array(
			array( "label" => "Add Page", "url" => "post-new.php?post_type=page" ),
			array( "label" => "Add Post", "url" => "post-new.php?post_type=post" ),
			array( "label" => "New Page", "url" => "post-new.php?post_type=page" ),
			array( "label" => "New Post", "url" => "post-new.php?post_type=post" ),
			array( "label" => "Edit Posts", "url" => "edit.php" ),
			array( "label" => "Edit Pages", "url" => "edit.php?post_type=page" ),
			array( "label" => "View All Posts", "url" => "edit.php" ),
			array( "label" => "View All Pages", "url" => "edit.php?post_type=page" ),
			array( "label" => "Media Library", "url" => "upload.php" ),
			array( "label" => "Add Media", "url" => "media-new.php" ),
			array( "label" => "Upload Media", "url" => "media-new.php" ),
			array( "label" => "New Media Item", "url" => "media-new.php" ),
			array( "label" => "Approve Comments", "url" => "edit-comments.php" ),
			array( "label" => "View Comments", "url" => "edit-comments.php" ),
			array( "label" => "Change Theme", "url" => "themes.php" ),
			array( "label" => "Install Theme", "url" => "theme-install.php" ),
			array( "label" => "Add Widgets", "url" => "widgets.php" ),
			array( "label" => "Edit Widgets", "url" => "widgets.php" ),
			array( "label" => "Add Menu", "url" => "nav-menus.php" ),
			array( "label" => "Edit Menus", "url" => "nav-menus.php" ),
			array( "label" => "Edit Settings", "url" => "options-general.php" ),
			array( "label" => "Edit Permalinks", "url" => "options-permalink.php" ),
			array( "label" => "Install Plugin", "url" => "plugin-install.php" ),
			array( "label" => "View Plugins", "url" => "plugins.php" ),
			array( "label" => "View Users", "url" => "users.php" ),
			array( "label" => "Add New User", "url" => "user-new.php" ),
		);

		foreach ( $butler_actions as $value) {
			if ( preg_match( '/' . $term . '/i', $value['label'] ) ) {
				$return[] = array(
					'label' => $value['label'],
					'url' => $value['url']
				);
			}
		}

	}

	wp_die( json_encode( apply_filters( 'wp_butler_ajax_actions', $return ) ) );
}; 

add_action( 'wp_ajax_wp_butler_actions', 'wp_butler_actions' );
