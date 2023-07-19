<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage = "Event Details";
if(!isset($_SESSION['user_id']))
{
	include('PublicProfileHeader.php');
}
else
{
	include('LoginHeader.php');
}

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

// if(!isset($_SESSION['user_id'])){
// 	$Obj->Redirect("index.php");
// }

if($userType=='club'){
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($userArray[0][type_of_club]==10){
	$Obj->Redirect("home_club.php");
}
}
else if($userType=='user'){
if(!isset($_GET['host_id'])){
$Obj->Redirect("index.php");
}
$sql = "select * from `clubs` where `id` = '".$_GET['host_id']."'";
$userArray = $Obj->select($sql) ;
if($userArray[0][type_of_club]==10){
	
$Obj->Redirect("host_profile.php?host_id=".$_GET['host_id']);
}
}

$sql_up=@mysql_query("select * from events where id='".$_GET['event_id']."'");
$op_shout=@mysql_fetch_assoc($sql_up);
   
   
?>      

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
						<h3 id="title">Event Details</h3>
						<form name="shout_out" class="v2_read_event" id="shout_out" method="post"   enctype="multipart/form-data">   
							<ul>
								<li>Event Name :</li>
								<li>
									<div style="width: 402px;word-wrap: break-word;">
										<?php echo $op_shout['eventname']; ?>
									</div>
								</li>
							</ul>
						
						 <ul id="adv-img">  
						   <li>Date :</li>
						   <li>
							   <?php echo date('F j, Y l g:i A',strtotime($op_shout['date'])); ?>
						   </li>
						 </ul>
						 
						<ul id="adv-img">  
							<li> Description :</li>
							<li>
								<div style="width: 349px;word-wrap: break-word;">  <?php echo $op_shout['description']; ?></div>
							</li>
						</ul>

						<ul id="adv-img">  
							<li> Event Image  :</li>
							<li>
								<?php $thumb_exp = explode('../', $op_shout['event_image_thumb']); ?>
								<div style="width: 349px;word-wrap: break-word;  border:1px solid #fff;"><img src="<?php echo $thumb_exp['1']; ?>" alt /></div>
							</li>
						</ul>
   <div class="clear"></div> <ul id="adv-img">
					   <?php if(isset($_GET['host_id'])){ ?>
					   <div class="clear"></div>
                        
                       <li> &nbsp;</li>
                       <li> 
						   <div>
							   <a  style="float:left;" href="listevent.php?host_id=<?php echo $_GET['host_id']; ?>" class="button backmargn">Back </a>
						   </div>
					   
					   <?php }
					   	else
					   	{
					   		?>
					   			<div style="float:left;"> <a href="listevent.php" class="button backmargn">Back </a></div>
					   		<?php 

					   	}

					    ?></li>
							</ul>
					   </form>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>

<?php include('Footer.php'); ?>