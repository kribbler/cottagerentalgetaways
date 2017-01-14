<?php
if(!defined('ABSPATH'))
	exit;
	
function cf_core_set_charset()
{


	global $wpdb;
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	
	/* MLM Component DB Schemea */
	if(!empty($wpdb->charset))
		return "DEFAULT CHARACTER SET $wpdb->charset";
	return '';
}

function cf_core_get_table_prefix()
{

	global $wpdb;
	return $wpdb->base_prefix;
}

function cf_core_install_contact()
{


	global $wpdb;
	$charset_collate = cf_core_set_charset();
	$table_prefix = cf_core_get_table_prefix();
	$sql[] ="CREATE TABLE {$table_prefix}cf_contact 
	(    id int(10) unsigned NOT NULL AUTO_INCREMENT,
	      name VARCHAR( 60 ) NOT NULL,
		  email VARCHAR( 60 ) NOT NULL,
		  mob VARCHAR( 60 ) NOT NULL,
		  msg VARCHAR( 60 ) NOT NULL,
		  	  PRIMARY KEY (`id`)
			  )
			 {$charset_collate} AUTO_INCREMENT=1";
			
		dbDelta($sql);

}



function cf_core_drop_tables()
{
	global $wpdb;
	$table_prefix = cf_core_get_table_prefix();
	
	$wpdb->query( "DROP TABLE {$table_prefix}cf_contact" );
	
	
	
}
?>