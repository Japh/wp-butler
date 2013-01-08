<?php
/*
Plugin Name: WP Butler
Plugin URI: http://wpbutler.com
Description: WP Butler brings you what you need in the Wordpress Admin. An autocomplete menu to let you jump to all the common tasks you may need to perform.
Author: Japh Thomson
Version: 1.2
Author URI: http://japh.com.au
License: GPL2
*/

/**
 * @package WP-Butler
 * @version 1.2
 */

class Japh_Butler {

	public $version = '1.2';

	function __construct() {

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'wpbutler_enqueue' ) );
			add_action( 'admin_footer', array( $this, 'wpbutler_footer' ) );
			add_action( 'wp_ajax_wp_butler_actions', array( $this, 'wpbutler_actions' ) );
		}

	}

	function wpbutler_footer() {
		echo '<div id="wp-butler-dialog" title="What would you like to do?">';
		echo '	<p>';
		echo '		<form id="wp-butler-form"><input type="text" placeholder="Just start typing..." id="wp-butler-field"><input type="hidden" id="wp-butler-nonce" name="wp-butler-nonce" value="' . wp_create_nonce( 'wp_butler_nonce' ) . '" /></form>';
		echo '	</p>';
		echo '</div>';
	}

	function wpbutler_enqueue() {
		// Enqueue styles
		if ( 'classic' == get_user_option( 'admin_color') ) {
			wp_enqueue_style ( 'butler-jquery-ui-css', plugin_dir_url( __FILE__ ) . 'jquery-ui-css/jquery-ui-classic.css' );
		}
		else {
			wp_enqueue_style ( 'butler-jquery-ui-css', plugin_dir_url( __FILE__ ) . 'jquery-ui-css/jquery-ui-fresh.css' );
		}
		wp_enqueue_style( 'wpbutler', plugins_url( 'wpbutler.css', __FILE__ ) );

		// Enqueue scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'keystroke', plugins_url( 'keystroke/jquery.keystroke.min.js', __FILE__ ), array( 'jquery' ), '0d77ac267da80cbe0e0ca8e6fe8b5b2bb8ee1bac', true );
		wp_enqueue_script( 'wpbutler', plugins_url( 'wpbutler.js', __FILE__ ), array( 'jquery-ui-core', 'jquery-ui-autocomplete', 'jquery-ui-dialog', 'keystroke' ), $this->version, true );
	}

	function wpbutler_actions() {
		$return = array();
		$term = $_REQUEST['term'];
		$nonce = $_REQUEST['_nonce'];

		if ( is_admin() && wp_verify_nonce( $nonce, 'wp_butler_nonce' ) ) {
			$butler_actions = array(
				array( "label" => "Go to Dashboard", "url" => "index.php" ),
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

			$butler_actions = apply_filters( 'wp_butler_ajax_actions', $butler_actions );

			foreach ( $butler_actions as $value ) {
				if ( preg_match( '/' . $term . '/i', $value['label'] ) ) {
					$return[] = array(
						'label' => $value['label'],
						'url' => $value['url']
					);
				}
			}
		}

		wp_die( json_encode( $return ) );
	}

}

$japh_butler = new Japh_Butler();
