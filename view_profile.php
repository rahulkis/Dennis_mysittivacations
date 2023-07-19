<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
	$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
	$message="Invalid Image.";
	}
}

if(isset($userID))
{
//include("CheckLogIn_con.Inc.php");
if(isset($_REQUEST['id'])){
	$userID=$_REQUEST['id'];
}
else {
$userID=$_SESSION['user_id'];	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Information | Mysitti</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script src="slider2/js/modernizr.custom.17475.js"></script>
<script src="js_validation/add_user.js" type="text/javascript"></script>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js_validation/update.js" type="text/javascript"></script>


<?php

  /******************/
 $sql = "select * from `user` where `id` = '".$userID."'";
 $userArray = $Obj->select($sql) ; 
  $first_name=$userArray[0]['first_name']; 
  $last_name=$userArray[0]['last_name'];
  $zipcode=$userArray[0]['zipcode'];
  $state=$userArray[0]['state'];
  $country=$userArray[0]['country'];
  if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
  $city=$userArray[0]['city'];
  $email=$userArray[0]['email'];
  $image_nm=$userArray[0]['image_nm'];
  $phone=$userArray[0]['phone'];
  
?> 

</head>

<body>
<div id="main">
    <div class="container">
    <?php 
	include('header.php');
	 ?>
    <div id="wrapper" class="space">
       <div id="title"> User Information</div>
        <?php
	   if($message!="")
	   {
	   ?>
      <div style="background-color:#FFCCFF; color:#FF0000"><?php echo $message; ?> </div> 
       <?php
     }
	 if($image_nm!="")
	 {
      ?>
      
       <div id="pic2">
           <img src="<?php echo $image_nm; ?>" height="157" width="135" /><br />
         <?php } else { ?>
         <div id="pic2"><img src="images/man4.jpg" /><br />
         <?php } ?>	
         <label><?php echo ucfirst($first_name)." ".ucfirst($last_name); ?></label><br />
         <?php
          if(isset($_REQUEST['id'])){ ?>
           <!--a href="upload_photo.php?id=<?php echo $_REQUEST['id']; ?>""> View Photos <a/-->
           <a  href="view_profile.php?id=<?php echo $_REQUEST['id'];?>">View Profile </a> <br/>
           	<a  href="upload_photo.php?id=<?php echo $_REQUEST['id'];?>"> View Photos <a/><br/>
          	 <a  href="upload_video.php?id=<?php echo $_REQUEST['id'];?>"> View Video <a/> <br/> 
		   <?php
		  }
		  else{ ?>
            <a href="edit_profile.php">Edit Profile </a> <br/>
       
           <a href="upload_photo.php"> Upload Photos <a/><br/>
           <a href="upload_video.php"> Upload Video <a/> <br/>
		   <?php } ?>
		  <?  if(!isset($_REQUEST['id'])){ ?>
		    <div class="prfile-panel">
			      <?php include('friend-right-panel.php') ?>
		</div>
		<?php } ?>
        </div>
        	  
        
       <div id="profile_box">
         <?php /*?><ul>
           <li>Profile Name:</li>
           <li><input name="pname" type="text" readonly="readonly" disabled="disabled" value="<?php echo ucfirst($first_name)." ".ucfirst($last_name); ?>" /></li>
         </ul><?php */?>
         <ul>
           <li>First Name:</li>
           <li><input name="fname" type="text" readonly="readonly" disabled="disabled" value="<?php echo ucfirst($first_name); ?>" /></li>
         </ul>
         <ul>  
           <li>Last Name:</li>
           <li><input name="lname" type="text" readonly="readonly" disabled="disabled" value="<?php echo ucfirst($last_name); ?>" /></li>
         </ul>
          <ul>  
           <li>Email:</li>
           <li><input name="email" readonly="readonly" readonly="readonly" disabled="disabled" type="text" value="<? echo $email; ?>" /></li>
         </ul>
          <ul>  
           <li>Phone:</li>
           <li><input name="phone"  type="text" readonly="readonly" disabled="disabled" value="<?php echo $phone; ?>" /></li>
         </ul>
          
        <!-- <ul>
           <li>Date of Birth:</li>
           <li><input name="dob" id="datepicker" readonly="readonly" disabled="disabled" type="text" value="<?php echo $dob; ?>" /></li>
         </ul>-->
         <ul>
           
             <li>Country:</li>
            
				 <?php 
              $country_nm_qry = mysql_query("SELECT `name` FROM `country` WHERE `country_id` = ".$country." ORDER BY `name` ASC");
              $country_nm = mysql_fetch_array($country_nm_qry);
            ?>
              <li><input name="country" id="datepicker" readonly="readonly" disabled="disabled" type="text" value="<?php echo $country_nm['name']; ?>" /></li>
         </ul>
         <ul>
           <li>State: </li>
           <?
            $statesql=mysql_query("select name from zone where zone_id='".$state."'");
			$state_nm = mysql_fetch_array($statesql);
			?>
 			<li><input name="country" id="datepicker" readonly="readonly" disabled="disabled" type="text" value="<?php echo $state_nm['name']; ?>" /></li>
         </ul>
         <ul>
           <li>City:</li>
           <?php
		   	$query_string = "SELECT `city_name` FROM `capital_city` WHERE `city_id` = ".$city."";
			 $result_city = @mysql_query($query_string);
		 	$city_nm = @mysql_fetch_array($result_city);
			   ?>
            <li><input name="city" type="text" readonly="readonly" disabled="disabled" value="<?php echo $city_nm['city_name']; ?>" /></li>
         </ul>
         <ul>
           <li>Zipcode:</li>
           <li><input name="zipcode" type="text" readonly="readonly" disabled="disabled" value="<?php echo $zipcode; ?>" /></li>
         </ul>
    </div>
       </div>
    </div>
    </div>
    <?php include('footer.php') ?>
</div>
</body>
</html>
<?php
}
else
{
$Obj->Redirect("login.php?msg=login");
}
?>