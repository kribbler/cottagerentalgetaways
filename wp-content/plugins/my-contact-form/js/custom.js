function validate(){

var x=document.forms["contact"]["fname"].value;
var y=document.forms["contact"]["email"].value;
var z=document.forms["contact"]["mob"].value;

if (x==null || x=="")
  {
  document.getElementById('name').style.display="block";
  document.getElementById('name').innerHTML="Please Enter the Name";
  document.getElementById('name').style.color="red";
   document.getElementById('name').style.margin="0 0 0 130px";
  return false;
  }
  else{
  
   document.getElementById('name').style.display="none";
  
  } 
var atpos=y.indexOf("@");
var dotpos=y.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=y.length)
  {
  document.getElementById('email').style.display="block";
    document.getElementById('email').innerHTML="Please Enter Valid Email";
    document.getElementById('email').style.color="red";
   document.getElementById('email').style.margin="0 0 0 130px";
  return false;
  }
  else{
  
  document.getElementById('email').style.display="none";
  
  }



if (/^\d{10}$/.test(z)) {
   
} else {
    document.getElementById('mob').style.display="block";
    document.getElementById('mob').innerHTML="Please Enter the 10 digit mobile no";
    document.getElementById('mob').style.color="red";
    document.getElementById('mob').style.margin="0 0 0 130px";
    
    return false;
}





}

