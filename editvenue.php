<?php
session_start();

include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
	
}
if($userType=='user'){
	$Obj->Redirect("index.php");
}
$titleofpage="Edit Venue";
include('headhost.php');
include('header.php');
include('headerhost.php');

$sql = "select type_of_club from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($userArray[0][type_of_club]!=10){
$Obj->Redirect("home_club.php");
}



if(isset($_POST['updateEvent'])){


$location=$_POST['locationName'];
$eventDate=$_POST['eventDate'];
$eventDate = date('Y-m-d', strtotime($_POST['eventDate']));
$startTime=$_POST['startTime'];
$endTime=$_POST['endTime'];
$map=$_POST['map'];
$date = date('Y-m-d H:i:s');
$row_id=$_POST['row_id'];
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
	
$sql="update `venues` set location='$location', date='$eventDate', start_time='$finalstart', end_time='$finalend',map='$map', modified_date='$date' where id='$row_id'";
mysql_query($sql);	

$time=strtotime($eventDate);
$month=date("F",$time);
$year=date("Y",$time);

// store session data
$_SESSION['year_Edit']=$year;
$_SESSION['month_Edit']=$month;
$_SESSION['venueedited']="yes";
$Obj->Redirect("listvenue.php");
}

}
if($_GET['edit']){
	
$sql = 'SELECT * FROM `venues` where id="'.$_GET['edit'].'"';
$retval = mysql_query( $sql);
$row = mysql_fetch_row($retval);


}else{
$Obj->Redirect("listvenue.php");
}

?> 

<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
					<h2>Edit Venue</h2>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" style="display:block;"  class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" style="display:block;" class="message" >'.$message['error']."</div>";
					} 

					?>
					<form method="POST" action="" enctype="multipart/form-data" class="musicadd">

					<div class="row">
					<span class="label">Location Name<font color='red'>*</font></span>
					<span class="formw">

					<input type="text" name="locationName" id="locationName" required value="<? if($row) { echo $row[2] ;}?>" /><br />
					</span>
					</div>

					<div class="row">
					<span class="label">Date<font color='red'>*</font></span>
					<span class="formw">

					<input type="text" class="date" name="eventDate"value="<? if($row) { 
					$postdates = trim($row[3]);

					$postdates = str_replace("/","-",$postdates);


					$curdates = date('d-m-Y' ,strtotime($postdates));


					echo $curdates ;}?>" required /><br />
					</span>
					</div>

					<div class="row">
					<span class="label">Start Time<font color='red'>*</font></span>
					<span class="formw">
					<input type="text"  id="startTime1" name="startTime" value="<? if($row) { echo date('d-m-Y H:i',strtotime($row[4])) ;}?>"  required />
					</span>
					</div>
					<div class="row">
					<span class="label">End Time<font color='red'>*</font></span>
					<span class="formw">
					<input type="text"  id="endTime2" name="endTime" value="<? if($row) { echo date('d-m-Y H:i',strtotime($row[5])) ;}?>" required />
					</span>
					</div>
					<div class="row">
					<span class="label">Map<font color='red'>*</font></span>
					<span class="formw">
					<textarea rows="4" cols="50" name="map" required><? if($row) { echo $row[6] ;}?></textarea>
					</span>
					</div>

					<div class="row" style="padding-top:20px;">
					<span class="formw">
					<input type="hidden" name="row_id" id="row_id" value="<? if($_GET['edit']) echo $_GET['edit']; ?>">
					<input type="submit" class="button"  name="updateEvent" id="updateEvent" value="Update">
					<input type="button" class="button" name="cancel" id="cancel" value="Cancel" onClick="cancelEdit()">
					</span>
					</div>

					<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" />



					</form>

		 </div>
		 
<script language="javascript">	
 function cancelEdit(){
   window.location='listvenue.php'
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



