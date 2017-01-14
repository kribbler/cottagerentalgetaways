<?php
function show_mymessage_after_plugin_activation() 
{
echo "<p>You can add contact address here <a href='".get_bloginfo('url')."/wp-admin/admin.php?page=contact-form'>click here</a></p>";
}
function cf_admin_menu() {

	$icon_url =  plugins_url()."/".CF_PLUGIN_NAME."/images/contact.png";
	 add_menu_page('Contact Form','Contact Form','administrator','contact-form','adminContactform',$icon_url,76);
	 add_submenu_page('contact-form','Contact List','Contact List','administrator','contact-list','adminContactlist');
	

}
function contactformsubmit($data){
$name=$data['fname'];
$email=$data['email'];
$mob=$data['mob'];
$msg=$data['msg'];
global $wpdb;
	
	$table_prefix = cf_core_get_table_prefix();

$table=$table_prefix.'cf_contact';
				$data=array('name' =>$name,'email' => $email,'mob' => $mob,'msg' => $msg );
	            $format=array('%s' ,'%s',	'%s','%s' ) ;
				$wpdb->insert($table, $data, $format );	
			 $admin_email = get_option( 'admin_email' ); 
				//$to = $admin_email;
			 	$to = 'rentals@cottagerentalgetaways.ca';
	$subject = "Contact form Information";
	$body = "Contact Form Detail: \n\n";
	$body .= "NAME: ".$name."\n\n";
	$body .= "EMAIL ID: " .$email."\n\n";
	$body .= "MOB: ".$mob."\n\n";
	$body .= "MSG: ".$msg."\n\n";
	$from = $email;
	$headers = "From:" . $from;
	wp_mail( $to, $subject, $body, $headers, $attachments );
	ob_flush();
				
				echo "<p style='color:green'>You have successfully submit information</p>";


}

function getlist(){

global $wpdb;
	
	$table_prefix = cf_core_get_table_prefix();
	
 $sql="select * from {$table_prefix}cf_contact order by id DESC";
$res=$wpdb->get_results($sql);
$i=1;
foreach($res as $resval){
?>

 <tr>
    <td><?php echo $i;?>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="checkBoxClass" id="<?php echo $resval->id;?>" /></td>
    <td><?php echo $resval->name;?></td>
    <td><?php echo $resval->email;?></td>
    <td><?php echo $resval->mob;?></td>	
    <td><?php echo $resval->msg;?></td>    
    <td><a href="?page=contact-form&&act=edit&id=<?php echo $resval->id; ?>">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?page=contact-list&&act=delete&id=<?php echo $resval->id; ?>"onclick="return confirm('Are you sure want to Delete');">Delete</a></td>    
  </tr>

<?php

$i++;
}


}



function deleterecord($id){


global $wpdb;
$table_prefix = cf_core_get_table_prefix();
$table=$table_prefix.'cf_contact';
$where=array( 'id' => $id ) ;
$wpdb->delete( $table, $where, $where_format = null );
echo "<p style='color:green'>You have successfully Deleted Record</p>";

}


function editrecord($id){

global $wpdb;
$table_prefix = cf_core_get_table_prefix();
$table=$table_prefix.'cf_contact';
 $sql="select * from $table where id='".$id."'";
 $res=$wpdb->get_results($sql);
return $res;



}

function updaterecord($data,$id){
global $wpdb;
$table_prefix = cf_core_get_table_prefix();
$table=$table_prefix.'cf_contact';
$where=array('id' => $id);
$data=array('name' => $data['fname'],'email' => $data['email'],'mob' => $data['mob'],'msg' => $data['msg']);
$wpdb->update( $table, $data, $where, $format = null); 
echo "<p style='color:green'>You have successfully Updated Record</p>";


}

function add_javascript(){
wp_enqueue_script( 'custom-script', plugins_url( 'my-contact-form/js/custom.js'));
wp_enqueue_style( 'custom-style', plugins_url( 'my-contact-form/css/style.css'));
wp_enqueue_script( 'wp-jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js' );



}
//add_action('init','deleteall');
function deleteall(){
global $wpdb;
$table_prefix = cf_core_get_table_prefix();
$table=$table_prefix.'cf_contact';
$deletequery = "TRUNCATE TABLE $table";
$wpdb->query($deletequery);
echo "<p style='color:green'>You have successfully Deleted All Records</p>";
}
?>