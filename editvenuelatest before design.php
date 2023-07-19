<?php 
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
$sql = "select type_of_club from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($userType=="club" && $userArray[0][type_of_club]!=10){
$Obj->Redirect("home_club.php");
}
 
?>

<style>
span.formw {
    float: right;
    text-align: left;
    width: 480px;
}
div.row {
    clear: both;
    padding-top: 5px
}
</style>
<?php


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
	$message['success'] = "Please select valid date and time ";
}else if(strtotime(date('y-m-d')) > strtotime($_POST['eventDate'])){
	$message['success'] = "Please select current or future date. ";
}
else if(strtotime($startTime) > strtotime($endTime)){
	$message['success'] = "Please  select valid start and end time";
}else{
$sql="update `venues` set location='$location', date='$eventDate', start_time='$startTime', end_time='$endTime',map='$map', modified_date='$date' where id='$row_id'";
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

$userID=$_SESSION['user_id'];


if(isset($userID))
{
 $sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($_GET['edit']){
	
$sql = 'SELECT * FROM `venues` where id="'.$_GET['edit'].'"';
$retval = mysql_query( $sql);
$row = mysql_fetch_row($retval);


}else{
$Obj->Redirect("listvenue.php");
}
$sql_getad=mysql_query("select * from host_ad where host_id='".$userID."'");
$rw_ad=@mysql_fetch_assoc($sql_getad);
//print_r($rw_ad);exit;

$query_string = "SELECT id FROM user where id!='1' AND is_online='1' AND logged_date < DATE_SUB(CURDATE(), INTERVAL 1 HOUR)  ORDER BY id";
$result = @mysql_query($query_string);
while($row_a = @mysql_fetch_array($result))
{
	mysql_query("update user set is_online='0' where id='".$row_a['id']."'");
}

// for coupon
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$userID."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
/// end here 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Venue</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script src="js_validation/add_user.js" type="text/javascript"></script>

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>

<script src="js_validation/update.js" type="text/javascript"></script>
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="slider2/css/elastislide.css" />
		<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
		<script src="slider2/js/modernizr.custom.17475.js"></script>
<script type="text/javascript" src="timepicker/jquery.timepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="timepicker/jquery.timepicker.css" />	
<link rel="stylesheet" type="text/css" href="timepicker/lib/site.css" />
<script type="text/javascript">
$(document).ready(function(){
    $('object').css('width', '300px');
});

function makelike(action,video_id,who_like_id)
{
 $.get('video-like_unlike.php?action='+action+'&video_id='+video_id+'&who_like_id='+who_like_id, function(data) {
$('#vid_'+video_id).html(data);

});
}
</script>

<?php

  /******************/
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}

		
 /**********************************/

?> 
<script>

$(document).ready(function() {	

	//select all the a tag with name equal to modal
	$('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		//Get the A tag
		var id = $(this).attr('href');
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});			

	$(window).resize(function () {
	 
 		var box = $('#boxes .window');
 
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
      
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
               
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
	 
	});
	
});

</script>

<style>
#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:500;
  background-color:#000;
  display:none;
}
  
 .window {
	position:fixed;
	left:0;
	top:0;
	display:none;
  	z-index:9000;
	height: 400px;
	width: 600px;
}  

</style>

<script>
function frame()
{
	document.getElementsByTagName('object').width = "200";
	document.getElementsByTagName('object').height = "200";

}
</script>

<!-- Light Box -->

<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />


<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>
<script src="lightbox/js/lightbox.js"></script>

<script>
  jQuery(document).ready(function($) {
      $('a').smoothScroll({
        speed: 1000,
        easing: 'easeInOutCubic'
      });

      $('.showOlderChanges').on('click', function(e){
        $('.changelog .old').slideDown('slow');
        $(this).fadeOut();
        e.preventDefault();
      })
  });

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2196019-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

function goto(url)
{
  window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
  return false;
}
</script>
<!-- Light Box -->
</head>
<body onLoad="frame();">
<div id="main">
    <div class="container">

<?php 
include('header.php');

?>
<div id="wrapper" class="space">
    
       <div class="prfile-panel">
	<?php include('club-right-panel.php') ?>
    </div>
    <div id="profile_box" style="overflow:hidden;margin: 30px 0 0 195px;">
<?php if($message['success'] != ""){ 
	
	echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
	}
if($message['error'] != ""){ 
		
		echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
		} 
		
		?>

<form method="POST" action="" enctype="multipart/form-data" class="musicadd">

 <h2 id="title1" class="title_txt" style="width:auto;text-align:center; border-bottom: 0;">Edit Venue</h2>
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
	<input type="text"  id="startTime1" name="startTime" value="<? if($row) { echo $row[4] ;}?>"  class="time" required />
	</span>
	</div>
	<div class="row">
	<span class="label">End Time<font color='red'>*</font></span>
	<span class="formw">
	<input type="text"  id="endTime2" name="endTime" value="<? if($row) { echo $row[5] ;}?>"  class="time" required />
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
 <input type="submit" class="button"  name="updateEvent" id="updateEvent" value="update">
    <input type="button" class="button" name="cancel" id="cancel" value="Cancel" onClick="cancelEdit()">
</span>
</div>
	
	<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" />
    
   
    
</form>
<!--
<form method="POST" action="" enctype="multipart/form-data" class="musicadd">

<h2 class="title_txt">Edit Venue</h2>
 <div class="field_ss"> 
   <label >Location Name<b><font color='red'><em>*</em></font></b></label>
    <input type="text" name="locationName" required id="locationName" value="<? if($row) { echo $row[2] ;}?>" /><br /> 
    </div>
    
	 <div class="field_ss"> 
   <label >label<b><font color='red'><em>*</em></font></b></label>
    <input type="text"  class="date" required name="eventDate" value="<? if($row) { echo $row[3] ;}?>"/><br /> 
    </div>
    
	 <div class="field_ss"> 
   <label >label<b><font color='red'><em>*</em></font></b></label>
    <input type="text" readonly="" placeholder="hh-mm-ss" required  name="start_time" class="time" size="10">
	<input type="text" readonly="" value="*end" size="10">
    </div>
    
    
   	 <div class="field_ss"> 
   <label >label<b><font color='red'><em>*</em></font></b></label>
<input type="text" placeholder="hh-mm-ss" class="time" name="startTime" value="<? if($row) { echo $row[4] ;}?>"size="10">
	<input type="text" required  placeholder="hh-mm-ss" name="endTime" value="<? if($row) { echo $row[5] ;}?>" size="10">
    </div> 
    
 
 <div class="field_ss"> 
   <label >Map<b><font color='red'><em>*</em></font></b></label>
<input type="text" placeholder="hh-mm-ss" name="startTime" value="<? if($row) { echo $row[4] ;}?>"size="10">
		 <textarea class="txtar_ss" rows="4" cols="50" name="map" ><? if($row) { echo $row[6] ;}?></textarea>
    </div>
	
    
    
    
   
   
 <div class="row" style="padding-top:20px;">
<span class="formw">
<input type="hidden" name="row_id" id="row_id" value="<? if($_GET['edit']) echo $_GET['edit']; ?>">
 <input type="submit" name="updateEvent" id="updateEvent" value="update">
    <input type="button" name="cancel" id="cancel" value="Cancel" onClick="cancelEdit()">
</span>
</div>
	
	<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" />
    
   
    
</form>-->


</div>
</div>
<?php include('footer.php') ?>
</div>

		<?php /*?> <?php  	 
					 $video_sql = "select * from `uploaed_video` where `user_id` = '".$userID."' order by video_id DESC limit 6";
		 			 $video_Array = mysql_query($video_sql);
		
					  while($video_row = mysql_fetch_array($video_Array))
						{ 
						?>
               			<div id="dialogx<?php echo $video_row["video_id"];?>" class="window">
						<div class="modal">
                        <div id="aq<?php echo $video_row["video_id"];?>">Loading the player...</div>
                        <script type="text/javascript">
                         jwplayer("aq<?php echo $video_row["video_id"];?>").setup({
                            file: "<?php echo $video_row["video_nm"];?>",
                            height :400 ,
                            width: 600
                            });
                            </script>
                    </div>
                    <a href="#"class="close" style="color:#FFF;"/>Close it</a>
						</div>

<!-- Mask to cover the whole screen -->
  <div id="mask"></div>
						 <?php
						}
						?><?php */?>
</body>
<script language="javascript">
function playvideo(id)
{
jwplayer('a'+id).stop();
$('#ve_'+id).click();
 
}
function  deletevideo(id)
{
var r=confirm("Are you sure you want delete this video");
if (r==true)
  {
    $.get('delete-video.php?video_id='+id, function(data) {
	 window.location='home_club.php';
	});
  }

 }
 function cancelEdit(){
   window.location='listvenue.php'
 }
 function deletephoto(id)
 {
   var r=confirm("Are you sure you want delete this Photo");
if (r==true)
  {
    $.get('delete-video.php?type=img&image_id='+id, function(data)
	{
	 window.location='home_club.php';
	});
  }
 
 }
</script>
</html>
<?php
}
else
{
$Obj->Redirect("login.php");
}
?>

<!--</body>
</html>-->
