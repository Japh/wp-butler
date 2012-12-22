<?php
/**
 * @package WP-Butler
 * @version 1.0
 */
/*
	/*
	Plugin Name: WP Butler
	Plugin URI: http://www.jordesign.com/wp-butler
	Description: WP Butler brings your what you need in the Wordpress Admin
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
	
	echo '<form id="wpButler"><input id="wpButlerField"></form>';  
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
