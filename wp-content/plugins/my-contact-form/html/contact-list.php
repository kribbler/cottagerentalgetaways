<?php
function adminContactlist(){
if($_REQUEST['id']&& $_REQUEST['act']=='delete'){
$id=$_REQUEST['id'];
deleterecord($id);
}


?>
<script>
$(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });

    $(".checkBoxClass").change(function(){
        if (!$(this).prop("checked")){
            $("#ckbCheckAll").prop("checked",false);
        }
    });
});

function mastercheckvalidat(){
var checkall=document.getElementById('ckbCheckAll').checked;
if(checkall==false){
alert("Please Select Master checkbox");
return false;
}
else{
alert("Are you sure want to Delete All Records");
return true;

}


}
</script>

<?php
if($_REQUEST['act']=='delete-all'){
deleteall();


}
?>
<table width="850" border="1">
  <tr>
    <td width="84"><strong>S.N</strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="ckbCheckAll" name="master" /></td>
    <td><strong> Name</strong></td>
    <td ><strong>Email</strong></td>
    <td><strong>Mob</strong></td>
    <td ><strong>Msg</strong></td>
    <td ><strong>Action</strong></td>
   
  </tr>
  <?php
getlist();
?>

</table>
<a href="?page=contact-list&&act=delete-all"onclick="return mastercheckvalidat();">Delete All</a>
<?php
}
?>
