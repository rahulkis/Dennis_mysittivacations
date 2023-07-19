<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID) || $userType=='user')
{
	$Obj->Redirect("index.php");
}
$titleofpage="Add Venue";
include('headhost.php');
include('header.php');
if($userType=="club")
{
	include('headerhost.php');
}

$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($userArray[0][type_of_club]!=10){
$Obj->Redirect("home_club.php");
}

if(isset($_POST['startTime'])){
$userID=$_SESSION['user_id'];
$location=$_POST['locationName'];
$eventDate=$_POST['eventDate'];
$startTime=$_POST['startTime'];
$endTime=$_POST['endTime'];
$map=$_POST['map'];
$date = date('Y-m-d H:i:s');
$eventDate = date('Y-m-d', strtotime($_POST['eventDate']));

if(strtotime(date('y-m-d')) > strtotime($_POST['eventDate']) && strtotime($startTime) >strtotime($endTime)){
	$message['error'] = "Please select valid date and time ";
}else if(strtotime(date('y-m-d')) > strtotime($_POST['eventDate'])){
	$message['error'] = "Please select current or future date. ";
}
else if(strtotime($startTime) > strtotime($endTime)){
	$message['error'] = "Please  select valid start and end time";
}else{
	$finalstart = date('Y-m-d H:i',strtotime($startTime));
	$finalend= date('Y-m-d H:i',strtotime($endTime));
	$sql = mysql_query("INSERT INTO `venues` (`id`, `host_id`, `location`, `date`, `start_time`, `end_time`,`map`, `created_date`, `modified_date`)VALUES ('','$userID', '$location','$eventDate','$finalstart','$finalend','$map','$date','$date')");
	
if($sql){
	
$_SESSION['venueadded']="yes";
$Obj->Redirect("listvenue.php");
}
}

}
?>



<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Add Venue</h2>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					} 

					?>
					<form method="POST" action="" enctype="multipart/form-data" class="musicadd" id="addvenueform">
	<div class="row">
	<span class="label"><label>Location Name</label><font color='red'>*</font></span>
	<span class="formw">
	
	<input type="text"  name="locationName" value="<?php if(isset($_POST['startTime'])){ echo $_POST['locationName'];}?>" id="locationName" required /><br />
	</span>
	</div>
	
		<div class="row">
	<span class="label"><label>Date</label><font color='red'>*</font></span>
	<span class="formw">
	
	<input type="text" class="date" value="<?php if(isset($_POST['startTime'])){ echo $_POST['eventDate'];}?>" id= "eventDate" name="eventDate" required /><br />
	</span>
	</div>
  
<div class="row">
	<span class="label"><label>Start Time</label><font color='red'>*</font></span>
	<span class="formw">
	<input type="text"  id="startTime1"  value="<?php if(isset($_POST['startTime'])){ echo $_POST['startTime'];}?>"  name="startTime"  required />
	</span>
	</div>
	<div class="row">
	<span class="label"><label>End Time</label><font color='red'>*</font></span>
	<span class="formw">
	<input type="text"  id="endTime2" value="<?php if(isset($_POST['startTime'])){ echo $_POST['endTime'];}?>"  name="endTime"  required />
	</span>
	</div>
   <div class="row">
	<span class="label"><label>Map</label><font color='red'>*</font></span>
	<span class="formw">
		<span class="mapinfo">POST Google Map Url(NOTE: How to get url <a style="color: #FECD07" target="blank" href="https://maps.google.co.in/">click here</a>)</span> 
		</br>
		<span class="mapinfo" style="color:gray;">Paste embed code from google map </span>
	</span>
	<span class="formw">
		
	 <textarea rows="4"  cols="50" id="map" name="map" required><?php if(isset($_POST['startTime'])){ echo $_POST['map'];}?></textarea>
	</span>
	</div>
   
 <div class="row" style="padding-top:20px;">
<span class="formw">
 <input class="button" type="submit" name="addsave" id="addsave" value="Save" onclick="disables()">
    <input class="button" type="button" name="cancel" id="cancel" value="Cancel" onClick="cancelEdit()">
</span>
</div>
	
	<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" />
    
   
    
</form>
   
		 </div>
		 
<script type="text/javascript">
function  disables()
{
	if(jQuery('#locationName').val()!='' && jQuery('#map').val()!='' && jQuery('#startTime1').val()!='' && jQuery('#endTime2').val()!='' && jQuery('#eventDate').val()!='')
	{
	
		jQuery("#addsave").attr('disabled',true);	jQuery('#addvenueform').submit();
	}
}	
function cancelEdit(){
   window.location='listvenue.php';
 }

</script>	

 </div>
 <?
include('club-right-panel.php');
?>
   
  </div>
</div>
<? 
include('footer.php');
?>



