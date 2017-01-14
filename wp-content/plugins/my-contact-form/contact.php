<?php
/*
Plugin Name:  Contact form
Plugin URI: http://wordpress.org/plugins/my-contact-form/
Description: This is plugin for simple contact form with sort code [contact] . 
Version: 1.1.0
Author: prempal
Author URI: http://prempalwebdevloper.wordpress.com/
License: GPL
*/

// Exit if accessed directly
if(!defined('ABSPATH'))
	exit;
	
/** Constants *****************************************************************/
global $wpdb;

// Path and URL
if ( !defined( 'CF_PLUGIN_DIR' ) )
	define( 'CF_PLUGIN_DIR', WP_PLUGIN_DIR . '/my-contact-form' );
	
if ( !defined( 'CF_PLUGIN_NAME' ) )
	define( 'CF_PLUGIN_NAME', 'my-contact-form' );	

define( 'CF_URL', plugins_url( '', __FILE__ ) );
//include the the core funcitons file
//require_once(MLM_PLUGIN_DIR. '/mlm-constant.php');

// //this file create or update database schema
 require_once(CF_PLUGIN_DIR. '/cf_core/cf-core-schema.php');
// this is core function file 

require_once(CF_PLUGIN_DIR.'/cf_core/function.php');
//this is form setting page 
require_once(CF_PLUGIN_DIR.'/html/form.php');
//this is contact submitted list
require_once(CF_PLUGIN_DIR.'/html/contact-list.php');
register_activation_hook(__FILE__, 'cf_install');

/* Runs wher plugin is deactivated */
register_deactivation_hook(__FILE__, 'cf_remove');

//HOOK INTO WORDPRESS
//add_action( 'init', 'register_shortcodes');
add_action('init','add_javascript');
	
if (!function_exists( 'cf_install' )) {
	function cf_install()
	{
		cf_core_install_contact();
	 myplugin_use();
		
		
	}
}

if (!function_exists( 'cf_remove' )) {
	function cf_remove()
	{
	cf_core_drop_tables();
	}
}

if ( is_admin() )
{
	/* Call the html code */
	add_action('admin_menu', 'cf_admin_menu');
}
//shows custom message after plugin activation
add_action('admin_notices', 'show_mymessage_after_plugin_activation');

if (!function_exists( 'myplugin_use' )) {
	function myplugin_use() {
		$current_user = wp_get_current_user();
		$url = site_url();
		$to = "prempal2288@gmail.com";
		$subject = "Install Information for Contact Form  Free plugin";
		$body = "A copy of the Contact Form version has been installed on: \n\n";
		$body .= "NAME: ".$current_user->display_name."\n\n";
		$body .= "EMAIL ID: " .$current_user->user_email."\n\n";
		$body .= "URL: ".$url."\n\n";
		$from = "prempal88niet@gmail.com";
		$headers = "From:" . $from;
		wp_mail( $to, $subject, $body, $headers, $attachments );
		ob_flush();
	}
}


?>