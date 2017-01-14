<?php
add_shortcode( 'contact', 'adminContactform' );
function adminContactform(){

if(isset($_POST['submit']))
	{
	
	if(isset($_POST['submit'])&&$_REQUEST['id']){
	updaterecord($_POST,$_REQUEST['id']);	
	
	}
	else{
		
          $data=$_POST;
	
		$net=contactformsubmit($data); 
		}
	}
	
	if($_REQUEST['id']&& $_REQUEST['act']=='edit')
	{
$id=$_REQUEST['id'];
global $wpdb;
$table_prefix = cf_core_get_table_prefix();
$table=$table_prefix.'cf_contact';
$getdata=editrecord($id);
foreach($getdata as $getdataval){
 $name=$getdataval->name;
$email=$getdataval->email;
$mob=$getdataval->mob;
$msg=$getdataval->msg;}

	}
	
?>

<form action="" name="contact" method="post" onsubmit="return validate();">

<label class="label">Name:</label><input type="text" name="fname" value="<?php echo $name?>"class="firstname"><div id="name" style="display:none;"></div><br><br>
<label class="label">Email:</label><input type="text" name="email" value="<?php echo $email?>"class="email"><div id="email" style="display:none;"></div><br><br>
<label class="label">Telephone:</label><input type="text" name="mob" value="<?php echo $mob?>"class="contact"><div id="mob"style="display:none;"></div><br><br>
<label class="label">Message:</label><textarea name="msg"class="input"><?php echo $msg?></textarea><br><br>
<input type="submit" name="submit" value="submit" class="submit">

</form>
<?php
}


?>