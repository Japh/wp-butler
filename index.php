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
	echo '<form id="wpButler"><input type="text" placeholder="just start typing..." style="width:90%; font-size:16px;padding:4px 0 6px 10px"id="wpButlerField"></form>';  
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
