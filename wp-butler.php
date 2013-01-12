<?php
/*
Plugin Name: WP Butler
Plugin URI: http://wpbutler.com
Description: WP Butler brings you what you need in the Wordpress Admin. An autocomplete menu to let you jump to all the common tasks you may need to perform, just hit <code>shift+alt+b</code>!
Version: 1.5
Author: Japh
Author URI: http://japh.com.au
License: GPL2
*/

/*  Copyright 2013  Japh  (email : wordpress@japh.com.au)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * @package WP-Butler
 * @version 1.5
 */

class Japh_Butler {

	public $version = '1.5';
	public $post_types = array();

	function __construct() {

		if ( is_admin() ) {
			$this->post_types = get_post_types( array( 'show_in_nav_menus' => true ), 'names', 'and' );
			add_action( 'admin_enqueue_scripts', array( $this, 'wpbutler_enqueue' ) );
			add_action( 'admin_footer', array( $this, 'wpbutler_footer' ) );
			add_action( 'wp_ajax_wp_butler_actions', array( $this, 'wpbutler_actions' ) );
		}

	}

	function wpbutler_footer() {
		echo '<div id="wp-butler-dialog" title="What would you like to do?">';
		echo '	<p>';
		echo '		<form id="wp-butler-form"><input type="text" placeholder="Just start typing..." id="wp-butler-field"><input type="hidden" id="wp-butler-nonce" name="wp-butler-nonce" value="' . wp_create_nonce( 'wp_butler_nonce' ) . '" /><input type="hidden" id="wp-butler-context" name="wp-butler-context" value="' . ( is_network_admin() ? 'network' : 'site' ) . '" /></form>';
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

	function wpbutler_generate_generic_actions( $actions ) {
		array_push( $actions, array( "label" => "Go to Dashboard", "url" => "index.php" ) );
		array_push( $actions, array( "label" => "Change Theme", "url" => "themes.php" ) );
		array_push( $actions, array( "label" => "Install Theme", "url" => "theme-install.php" ) );
		array_push( $actions, array( "label" => "View Plugins", "url" => "plugins.php" ) );
		array_push( $actions, array( "label" => "Install Plugin", "url" => "plugin-install.php" ) );
		array_push( $actions, array( "label" => "View Users", "url" => "users.php" ) );
		array_push( $actions, array( "label" => "Add New User", "url" => "user-new.php" ) );

		return $actions;
	}

	function wpbutler_generate_site_actions( $actions ) {
		array_push( $actions, array( "label" => "Media Library", "url" => "upload.php" ) );
		array_push( $actions, array( "label" => "Add Media", "url" => "media-new.php" ) );
		array_push( $actions, array( "label" => "Upload Media", "url" => "media-new.php" ) );
		array_push( $actions, array( "label" => "New Media Item", "url" => "media-new.php" ) );
		array_push( $actions, array( "label" => "Approve Comments", "url" => "edit-comments.php" ) );
		array_push( $actions, array( "label" => "View Comments", "url" => "edit-comments.php" ) );
		array_push( $actions, array( "label" => "Add Widgets", "url" => "widgets.php" ) );
		array_push( $actions, array( "label" => "Edit Widgets", "url" => "widgets.php" ) );
		array_push( $actions, array( "label" => "Add Menu", "url" => "nav-menus.php" ) );
		array_push( $actions, array( "label" => "Edit Menus", "url" => "nav-menus.php" ) );
		array_push( $actions, array( "label" => "Edit Settings", "url" => "options-general.php" ) );
		array_push( $actions, array( "label" => "Edit Permalinks", "url" => "options-permalink.php" ) );

		return $actions;
	}

	function wpbutler_generate_multisite_actions( $actions ) {
		return $actions;
	}

	function wpbutler_generate_post_type_actions( $actions ) {
		foreach ( $this->post_types as $post_type ) {
			$name = ucfirst( $post_type );
			$new_url = 'post-new.php?post_type=' . $post_type;
			$edit_url = 'edit.php?post_type=' . $post_type;

			array_push( $actions, array( "label" => "Add " . $name, "url" => $new_url ) );
			array_push( $actions, array( "label" => "Create " . $name, "url" => $new_url ) );
			array_push( $actions, array( "label" => "New " . $name, "url" => $new_url ) );
			array_push( $actions, array( "label" => "Edit " . $name . "s", "url" => $edit_url ) );
			array_push( $actions, array( "label" => "View All " . $name . "s", "url" => $edit_url ) );
		}

		return $actions;
	}

	function wpbutler_actions() {
		$return = array();
		$term = $_REQUEST['term'];
		$nonce = $_REQUEST['_nonce'];
		$context = $_REQUEST['_context'];

		if ( is_admin() && wp_verify_nonce( $nonce, 'wp_butler_nonce' ) ) {
			$butler_actions = array();

			$butler_actions = $this->wpbutler_generate_generic_actions( $butler_actions );
			if ( is_network_admin() || $context == 'network' ) {
				$butler_actions = $this->wpbutler_generate_multisite_actions( $butler_actions );
			}
			else {
				$butler_actions = $this->wpbutler_generate_site_actions( $butler_actions );
			}
			$butler_actions = $this->wpbutler_generate_post_type_actions( $butler_actions );

			$butler_actions = apply_filters( 'wp_butler_ajax_actions', $butler_actions );

			$random_action_url = $butler_actions[mt_rand( 0, count( $butler_actions ) )]['url'];
			array_push( $butler_actions, array( "label" => "Surprise me!", "url" => $random_action_url ) );

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

function execute_wp_butler() {
	$japh_butler = new Japh_Butler();
}
add_action( 'admin_init', 'execute_wp_butler' );
