<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage = "Calendar";

if(!isset($_SESSION['user_id']))
{
	include('PublicProfileHeader.php');
}
else
{
	if(isset($_GET['host_id']))
	{
		include('NewHeadeHost.php');
	}
	else
	{
		include('NewHeadeHost.php');	
	}
}

$userID=$_SESSION['user_id'];
$para="";

$titleofpage = "Calendar";
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
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
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
if(isset($_REQUEST['host_id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
$userType= $_SESSION['user_type'];

if($userType=='club'){
 $sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
$userOrhost=" AND host_id =".$userID;
$hostNEW = $userID;
$type_of_club =$userArray[0]['type_of_club'];
if($userType=="club" && $userArray[0][type_of_club]!=11){
//$Obj->Redirect("home_club.php");
}
}else if($userType=='user'){
if(!isset($_GET['host_id'])){
//$Obj->Redirect("host_profile.php");
}
$hostID=$_GET['host_id'];


$sql = "select * from `clubs` where `id` = '".$hostID."'";
$userArray = $Obj->select($sql) ;
$type_of_club =$userArray[0]['type_of_club'];
if($userType=="user" && $type_of_club!=11){
	//$Obj->Redirect("host_profile.php?host_id=".$hostID);
}
$userOrhost=" AND host_id =".$hostID;
$hostNEW = $hostID;
}
		
 /**********************************/

?> 


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

#nav
{
	width: 100%;
}
span.backtoToday {
    float: none !important;
    font-size: 12px;
    width: 20%;
}

</style>







<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   
		if(!isset($_GET['host_id']))
		{
			include('club-right-panel.php');	
		}
		else
		{ 
			include('host_left_panel.php');
		} 
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">

					<!-- <a href="eventscalendar.php"><h3 class="calList">Calendar</h3></a> -->
					<!-- <a href="listevent.php"><h3 class="listCaln">List</h3></a> -->
					<!-- Events CALENDAR -->
					
					
					
					
					
					<?php
					if($userType=='club' && !isset($_GET['host_id'])){
						echo '<div id="vieweventslist"><a class="button btn_ss" href="addevent.php"><i>Add Event?</i><span> <img src="images/addevent.png" alt=""></span></a></div>';
					}
					
					
					//echo draw_calendar($month,$year,$events,$new_eventsx,$bookingsx);
					
					?>
					</div>		
						
						<!-- EVENTS CALENDAR ENDS --> 
						<div class="tiva-events-calendar full" data-source="php"></div>
					 </div>
				</div>
			</div>
		</article>
	</div>
</div>
				
<script type="text/javascript">
	
	$(document).ready(function(){
	$(".tooltip").mouseenter(function(e){
	    e.preventDefault();
	    $(this).children(".event").fadeIn("slow");
	});
	$(".tooltip").mouseleave(function(e){
	    e.preventDefault();
	    $(this).children(".event").fadeOut("fast");
	});
	});
	
	function delrecoreds(id) {
	
	  $val= jQuery('#current_month_for_venue').val();
		$current_year= jQuery('#current_year_for_venue').val(); 
	   

  if(confirm('Are You sure You want to delete this event.'))
  {
	  
	 $.get( "deleteevent.php?id="+id+"&month="+$val+"&year="+$current_year, function( data ) {
		window.location='eventscalendar.php';
		$('.list-view').addClass('active');
		// var d = document.getElementById("div1");
		// d.className += " otherclass";
		});
  }
   else
   {
	
	}

}
</script>
<?php include('LandingPageFooter.php');

?>