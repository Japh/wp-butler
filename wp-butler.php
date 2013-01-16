<?php
/*
Plugin Name: WP Butler
Plugin URI: http://wpbutler.com
Description: WP Butler brings you what you need in the Wordpress Admin. An autocomplete menu to let you jump to all the common tasks you may need to perform, just hit <code>shift+alt+b</code>!
Version: 1.7
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
 * @version 1.7
 */

class Japh_Butler {

	public $version = '1.7';
	public $post_types = array();
	public $taxonomies = array();

	function __construct() {

		if ( is_admin() ) {
			load_plugin_textdomain( 'wp-butler', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

			$this->post_types = get_post_types( array( 'show_in_nav_menus' => true ), 'objects', 'and' );
			$this->taxonomies = get_taxonomies( array( 'show_in_nav_menus' => true ), 'objects', 'and' );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'admin_footer', array( $this, 'footer' ) );
			add_action( 'wp_ajax_wp_butler_actions', array( $this, 'actions' ) );
		}

	}

	function footer() {
		echo '<div id="wp-butler-dialog" title="' . __( "What would you like to do?", "wp-butler" ) . '">';
		echo '	<p>';
		echo '		<form id="wp-butler-form"><input type="text" placeholder="' . __( "Just start typing", "wp-butler" ) . '..." id="wp-butler-field"><input type="hidden" id="wp-butler-nonce" name="wp-butler-nonce" value="' . wp_create_nonce( 'wp_butler_nonce' ) . '" /><input type="hidden" id="wp-butler-context" name="wp-butler-context" value="' . ( is_network_admin() ? 'network' : 'site' ) . '" /></form>';
		echo '	</p>';
		echo '</div>';
	}

	function enqueue() {
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

	function generate_generic_actions( $actions ) {
		array_push( $actions, array( "label" => __( "Dashboard" ), "url" => "index.php" ) );
		array_push( $actions, array( "label" => __( "Home" ), "url" => "index.php" ) );
		array_push( $actions, array( "label" => __( "WordPress Updates" ), "url" => "update-core.php" ) );
		array_push( $actions, array( "label" => __( "Manage Themes" ), "url" => "themes.php" ) );
		array_push( $actions, array( "label" => __( "Install Themes" ), "url" => "theme-install.php" ) );
		array_push( $actions, array( "label" => __( "Plugins" ), "url" => "plugins.php" ) );
		array_push( $actions, array( "label" => __( "Update Plugins" ), "url" => "plugins.php" ) );
		array_push( $actions, array( "label" => __( "Edit Plugins" ), "url" => "plugin-editor.php" ) );
		array_push( $actions, array( "label" => __( "Install Plugins" ), "url" => "plugin-install.php" ) );
		array_push( $actions, array( "label" => __( "All Users" ), "url" => "users.php" ) );
		array_push( $actions, array( "label" => __( "Add New User" ), "url" => "user-new.php" ) );
		array_push( $actions, array( "label" => __( "Profile" ), "url" => "profile.php" ) );

		return $actions;
	}

	function generate_site_actions( $actions ) {
		array_push( $actions, array( "label" => __( "Media Library" ), "url" => "upload.php" ) );
		array_push( $actions, array( "label" => __( "Upload New Media" ), "url" => "media-new.php" ) );
		array_push( $actions, array( "label" => __( "Comments" ), "url" => "edit-comments.php" ) );
		array_push( $actions, array( "label" => __( "Widgets" ), "url" => "widgets.php" ) );
		array_push( $actions, array( "label" => __( "Menus" ), "url" => "nav-menus.php" ) );
		array_push( $actions, array( "label" => __( "Create Menu" ), "url" => "nav-menus.php" ) );
		array_push( $actions, array( "label" => __( "General Settings" ), "url" => "options-general.php" ) );
		array_push( $actions, array( "label" => __( "Writing Settings" ), "url" => "options-writing.php" ) );
		array_push( $actions, array( "label" => __( "Reading Settings" ), "url" => "options-reading.php" ) );
		array_push( $actions, array( "label" => __( "Discussion Settings" ), "url" => "options-discussion.php" ) );
		array_push( $actions, array( "label" => __( "Media Settings" ), "url" => "options-media.php" ) );
		array_push( $actions, array( "label" => __( "Permalink Settings" ), "url" => "options-permalink.php" ) );
		array_push( $actions, array( "label" => __( "Tools" ), "url" => "tools.php" ) );
		array_push( $actions, array( "label" => __( "Import" ), "url" => "import.php" ) );

		return $actions;
	}

	function generate_multisite_actions( $actions ) {
		return $actions;
	}

	function generate_post_type_actions( $actions ) {
		foreach ( $this->post_types as $post_type => $post_type_object ) {
			$name = ucfirst( $post_type_object->labels->name );
			$singular_name = ucfirst( $post_type_object->labels->singular_name );
			$new_url = 'post-new.php?post_type=' . $post_type;
			$edit_url = 'edit.php?post_type=' . $post_type;

			array_push( $actions, array( "label" => $singular_name . " -> " . __( "Add" ), "url" => $new_url ) );
			array_push( $actions, array( "label" => $name . " -> " . __( "Edit" ), "url" => $edit_url ) );
			array_push( $actions, array( "label" => $name . " -> " . __( "View" ), "url" => $edit_url ) );
		}

		return $actions;
	}

	function generate_taxonomy_actions( $actions ) {
		foreach ( $this->taxonomies as $taxonomy => $taxonomy_object ) {
			$name = ucfirst( $taxonomy_object->labels->name );
			$singular_name = ucfirst( $taxonomy_object->labels->singular_name );
			$edit_url = 'edit-tags.php?taxonomy=' . $taxonomy . '&post_type=' . $taxonomy_object->object_type[0];
			$new_url = $edit_url;

			array_push( $actions, array( "label" => $singular_name . " -> " . __( "Add" ), "url" => $new_url ) );
			array_push( $actions, array( "label" => $name . " -> " . __( "Edit" ), "url" => $edit_url ) );
			array_push( $actions, array( "label" => $name . " -> " . __( "View" ), "url" => $edit_url ) );
		}

		return $actions;
	}

	function actions() {
		require_once( ABSPATH . '/wp-includes/l10n.php' );

		$return = array();
		$term = $_REQUEST['term'];
		$nonce = $_REQUEST['_nonce'];
		$context = $_REQUEST['_context'];

		$term_words = explode( ' ', $term );
		$keyword = $term_words[0];

		if ( is_admin() && wp_verify_nonce( $nonce, 'wp_butler_nonce' ) ) {

			$butler_actions = array();

			switch ( $keyword ) {
				case __( 'search' ):
				case __( 'edit' ):
					array_shift( $term_words );
					$term = implode( ' ', $term_words );
					$params = array(
						's' => $term,
						'posts_per_page' => 10,
					);
					$search = new WP_Query( $params );

					while ( $search->have_posts() ) :
						$search->next_post();
						array_push( $butler_actions, array( "label" => get_the_title( $search->post->ID ), "url" => get_edit_post_link($search->post->ID,'raw') ) );
					endwhile;

					break;
				case __( 'view' ):
					array_shift( $term_words );
					$term = implode( ' ', $term_words );
					$params = array(
						's' => $term,
						'posts_per_page' => 10,
					);
					$search = new WP_Query( $params );

					while ( $search->have_posts() ) :
						$search->next_post();
						array_push( $butler_actions, array( "label" => get_the_title( $search->post->ID ), "url" => get_permalink($search->post->ID) ) );
					endwhile;

					break;
				default:
					$butler_actions = $this->generate_generic_actions( $butler_actions );
					if ( is_network_admin() || $context == 'network' ) {
						$butler_actions = $this->generate_multisite_actions( $butler_actions );
					}
					else {
						$butler_actions = $this->generate_site_actions( $butler_actions );
					}
					$butler_actions = $this->generate_post_type_actions( $butler_actions );
					$butler_actions = $this->generate_taxonomy_actions( $butler_actions );

					$butler_actions = apply_filters( 'wp_butler_ajax_actions', $butler_actions );

					$random_action_url = $butler_actions[mt_rand( 0, count( $butler_actions ) ) - 1]['url'];
					array_push( $butler_actions, array( "label" => __( "Surprise me!", "wp-butler" ), "url" => $random_action_url ) );
			}

			foreach ( $butler_actions as $value ) {
				if ( preg_match( '/' . $term . '/i', $value['label'] ) ) {
					$return[] = array(
						'label' => html_entity_decode( $value['label'], ENT_QUOTES, get_option( 'blog_charset' ) ),
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
