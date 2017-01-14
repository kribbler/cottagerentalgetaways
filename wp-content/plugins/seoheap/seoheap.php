<?php
/*
Plugin Name: SEOHeap
Plugin URI: http://www.seoheap.com/
Description: Functions commonly used for custom functions developed by SEOHeap.com
Author: James Cantrell
Version: 1.0.0
Author URI: http://www.seoheap.com/
*/

include_once dirname(__FILE__).'/global.php';


function add_plugin_meta_boxes() {  
    add_meta_box(  
        'wp_custom_plugin',  
        'Plugins',  
        'wp_custom_plugin',  
        'page',  
        'side'  
    );  
}
add_action('add_meta_boxes', 'add_plugin_meta_boxes');

function wp_custom_plugin($post) {  
  
    wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_plugin_nonce');  
	
	$plug = get_post_meta($post->ID, 'wp_custom_plugin', true);
      
    echo '<p class="description">Comma separated list of plugins</p>';  
    echo '<input type="text" id="wp_custom_plugin" name="wp_custom_plugin" value="',htmlq($plug),'" size="25">';  
}
function save_custom_plugin_meta_data($id) {  
    if(!wp_verify_nonce($_POST['wp_custom_plugin_nonce'], plugin_basename(__FILE__))) {  
      return $id;  
    }
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {  
      return $id;  
    }   
    if('page' == $_POST['post_type']) {  
      if(!current_user_can('edit_page', $id)) {  
        return $id;  
      }
    } else {  
        if(!current_user_can('edit_page', $id)) {  
            return $id;  
        }
	}
    $plug='';
	if (!empty($_POST['wp_custom_plugin'])) {
		$plug=post('wp_custom_plugin');
	}
    add_post_meta($id, 'wp_custom_plugin', $plug);  
    update_post_meta($id, 'wp_custom_plugin', $plug); 
      
}
add_action('save_post', 'save_custom_plugin_meta_data');  
add_action('wp_head', 'load_page_plugins');

function load_page_plugins() {
	if (!is_page())
		return;
	$p=get_post_meta(get_the_ID(), 'wp_custom_plugin', true);
	$p=explode(',',$p);
	foreach ($p as $a) {
		$a=trim($a);
		if (!$a)
			continue;
		plugin($a);	
	}
}