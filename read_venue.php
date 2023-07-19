<?php
session_start();
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}
$titleofpage="Venue Details";
include('headhost.php');
include('header.php');
if($userType=="club"){
include('headerhost.php');
}

if($userType=='club'){
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray= $Obj->select($sql) ;
if($userArray[0][type_of_club]!=10){
	$Obj->Redirect("home_club.php");
}
}
else if($userType=='user'){
if(!isset($_GET['host_id'])){
$Obj->Redirect("index.php");
}
$sql = "select * from `clubs` where `id` = '".$_GET['host_id']."'";
$userArray = $Obj->select($sql) ;
if($userArray[0][type_of_club]!=10){	
$Obj->Redirect("host_profile.php?host_id=".$_GET['host_id']);
}
}
$sql_up=@mysql_query("select * from venues where id='".$_GET['id']."'");
   $op_shout=@mysql_fetch_assoc($sql_up);
?>      
<div class="home_wrapper">
	<div class="main_home">
		<div class="home_content">
			<div class="home_content_top">
				<h2>Venue Details</h2>
						<form name="shout_out" id="shout_out" method="post"   enctype="multipart/form-data">



						<ul>
						<li>Location : </li>
						<li>
						<div style="width: 402px;word-wrap: break-word;">
						<?php echo $op_shout['location']; ?>
						</div>
						</li>
						</ul>


						<ul id="adv-img">  
						<li>Venue Date : </li>
						<li>

						<?php echo date('M d,Y',strtotime($op_shout['date'])); ?>
						</li>
						</ul>
						<ul id="adv-img">  
						<li>Time : </li>
						<li>


						<? 
						$startime=strtotime($op_shout['start_time']);
						$time_in_24_hour_format  = date("g:i a", $startime);?>
						<?php echo "&nbsp;".$time_in_24_hour_format."-"; ?>
						<?php 
						$endtime=strtotime($op_shout['end_time']);
						$time_in_24_hour_endformat  = date("g:i a", $endtime);
						echo $time_in_24_hour_endformat; ?>
						</li>
						</ul>
						<ul id="adv-img">  


						<li>
						<?php echo  $op_shout['map'];?>  
						</li>
						</ul>



						</form>
   
		 </div>
		  
		  </div>		
		  <? if($_SESSION['user_type']=='user'){?>
				<?php include('host_left_panel.php'); ?>
                     <? }else {  ?>
                     
                          <?php include('club-right-panel.php') ?>
                       		
                       <?php } ?>
	</div>	
</div>


<?
include('footer.php');
?>
