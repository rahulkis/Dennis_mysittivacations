<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mysitti | Profile</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script src="js_validation/add_user.js" type="text/javascript"></script>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js_validation/update.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
var xmlhttp;
function ajaxFunction(url,myReadyStateFunc)
{
   if (window.XMLHttpRequest)
   {
      // For IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
   }
   else
   {
      // For IE5, IE6
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange= myReadyStateFunc;        // myReadyStateFunc = function
   xmlhttp.open("GET",url,true);
   xmlhttp.send();
}
function showState(x)
{
 ajaxFunction("getstate.php?country_id="+x, function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
               var s = xmlhttp.responseText;    //   s = "1,2,3,|state1,state2,state3,"
               s=s.split("|");                              //   s = ["1,2,3,", "state1,state2,state3,"]
               sid = s[0].split(",");  
			                 //  sid = [1,2,3,]
               sval = s[1].split(",");      
			                 //  sval = [state1, state2, state3,]
              st = document.getElementById('state');
			    st.length=0; 
              for(i=0;i<sid.length-1;i++)
             {
                    st[i] = new Option(sval[i],sid[i]);
	
              }              
        }
	});
}
</script>
<script>
$(function() {
$( "#datepicker" ).datepicker({
changeMonth: true,

changeYear: true
});
});
</script>
<style>
#profile_box ul li{
padding-bottom:15px;
color:#888787;
font-family:Arial, Helvetica, sans-serif;
font-size:16px;
width:282px;
display:table-cell;
}
</style>
<!--/*******************************-->









<?php
 
  /******************/
  if(isset($_REQUEST['id']))
  {
	  $id=$_REQUEST['id'];
 $sql = "select * from `clubs` where `id` = '".$id."'";
 $userArray = $Obj->select($sql) ; 

 
 
  $club_name=$userArray[0]['club_name']; 
  
  $type_of_club =$userArray[0]['type_of_club'];
  
  if(isset($userArray[0]['type_details_of_club']) && $userArray[0]['type_details_of_club']!='')
  {
  	$type_details_of_club =$userArray[0]['type_details_of_club'];
  }else
  {
	  $type_details_of_club = 'N/A';
  }
  
  $club_email=$userArray[0]['club_email'];
  $password=$userArray[0]['password'];
   $club_address=$userArray[0]['club_address'];
  $club_contact_no=$userArray[0]['club_contact_no'];
   $club_country=$userArray[0]['club_country'];
 $club_state=$userArray[0]['club_state'];
  $club_city=$userArray[0]['club_city'];
  $zip_code=$userArray[0]['zip_code'];
    $google_map_url=$userArray[0]['google_map_url'];
  }
?> 

</head>

<body>
<div id="main">
    <div class="container">
    <?php 
	include('header.php');
	 ?>
    <div id="wrapper" class="space">
      <div class="box8">
      <div id="title">View HOST Profile</div>
   
         <div class="formtopdiv">
              <b> <div class="formnamediv">Name of HOST:</div>
              <label  > <?php echo $club_name;?></label> </b>
            </div>
         <div class="formtopdiv">
              <b> <div class="formnamediv">Type of HOST:</div>
              <label  > <?php echo $type_of_club;?></label> </b>
            </div>
            
          <div class="formtopdiv">
              <b> <div class="formnamediv">Type Details Of HOST:</div>
              <label  > <?php echo $type_details_of_club;?></label> </b>
            </div>     
            
        
              
        	 <div class="formtopdiv">
            <b>   <div class="formnamediv">HOST Contact No:</div>
               <label  ><?php echo $club_contact_no;?>  </label  ></b>
         </div>
         
         
          
          
           <div class="formtopdiv">
           <b>  <div class="formnamediv">HOST Address:</div>
           <label  ><?php echo  $club_address;?> </label  ></b>
       </div>
           
            <div class="formtopdiv">
            <?php 
		 $countrysql="select name from country where country_id='".$club_country."'";
		 $country_list = mysql_query($countrysql);
		 
		 while($country1=mysql_fetch_array($country_list))
		 {
			 $coun_name= $country1["name"];
		 }
		 ?>
            <b> <div class="formnamediv">Country:</div>
            <label><?php echo $coun_name; ?></label></b>
            
         </div>
         
          <div class="formtopdiv">
          <?php 
		 $countrysql1="select name from zone where zone_id='".$club_state."'";
		 $country_list1 = mysql_query($countrysql1);
		 
		 while($country12=mysql_fetch_array($country_list1))
		 {
			 $coun_name1= $country12["name"];
		 }
		 ?>
              <b><div class="formnamediv">State:</div>
             <label><?php echo $coun_name1; ?></label></b> 
             </div>  
            
         
             <div class="formtopdiv">
              <b><div class="formnamediv">City:</div>
           <label><?php echo $club_city;?></label></b>
           </div>
           
           <div class="formtopdiv">
             <b> <div class="formnamediv">
             Zipcode:</div>
                    <label><?php echo $zip_code;?>         </label></b>
       </div>
       
            <div class="formtopdiv">
              <b><div class="formnamediv">
          Clubs Map Direction:</div><br/>
               <label><?php echo $google_map_url;?>  </label></b>
           </div>
           
        </div>   
    </div>
           
       
        
    </form>
    </div>
    
       
  
    
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
</html>
