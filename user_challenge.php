<?php
ob_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="User Challenge";
include('NewHeadeHost.php');
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
//include '../googleplus-config.php';

// ini_set("display_errors", "1");
// error_reporting(E_ALL);


if(!isset($userID)){ $Obj->Redirect($SiteURL); die;}

if(isset($_GET['id'])){
	 $UserID=$_GET['id']; 
	}
	else {
	 $UserID=$_SESSION['user_id'];	
	}
	
	 $sql="select c.*,uc.is_read,uc.owner_id from user_to_content as uc left join  contest as c on(c.contest_id=uc.cont_id) where uc.user_id='".$UserID."' AND cont_type='content' AND c.contest_id != 'NULL' group by uc.cont_id ORDER BY c.contest_id DESC";
	 $contests_list = mysql_query($sql);

	$sql = "select * from `user` where `id` = '".$UserID."'";
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
	/**********************************/
	 $profile_name=$first_name." ".$last_name;
	 $titleofpage=$profile_name." Challenge List";
?> 

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'mysitti.com');
  ga('send', 'pageview');
  
function deletecon(id)
{
	if(confirm('Are you sure you want delete this challenge'))
	{
		$.get( "deletecontests.php?id="+id, function( data )
		 {
			window.location='user_challenge.php';
	   });
	}else
	{
		
	}

}

function deletecon_user(id)
{
	if(confirm('Are you sure you want remove this challenge'))
	{
	$.get( "deletecontests.php?id="+id+'&type=friend', function( data )
	 {
		window.location='user_challenge.php';
   });
	}else
	{
		
	}

}

</script>
<!--<link rel="stylesheet" type="text/css" href="https://mysitti.com/css/new_portal/style.css" />-->
<div class="v2_container">
  <div class="v2_inner_main">
	
	<?php
	if(isset($_GET['id']))
	{
		if($_SESSION['user_type'] == 'user')
		{
			include('friend-profile-panel.php');  
		}
		else
		{
			include('friend-profile-panel.php');  	
		}
	}
	else
	{
			include('friend-right-panel.php');
	}
	?>
	
	<article class="forum_content v2_contentbar">
		<div class="v2_rotate_neg">
			<div class="v2_rotate_pos">
				<div class="v2_inner_main_content">
		  <h3 id="title" class="toph2"><?php echo $profile_name; ?>  Challenge List</h3>
		  
		  
			 <? if(isset($_SESSION['popup_add_post'])){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Challenge Successfully Added</div> 
				  
			  <?  unset($_SESSION['popup_add_post']); }?>		  
		  
		<?php
	   if($message!="")
	   {
	   ?>
	  <div id="msg" style="background-color:#FFCCFF; color:#008000"><?php echo $message; ?> </div> 
	   <?php
	 }
	 ?>

   		<div id="middle">
				<?php  
				  	if(!isset($_GET['id']))
			  		{
			  	?>
					 	<div class="challange " > 
				 			<a style="  margin-top: 10px;" class="button" href="javascript:void(0);"  onclick="goto('add_user_challenge.php')" >Add Challenge</a>
			 			</div>
 				<?php 	} 	?>
				<!-- Start Host Information-->
						<div id="profile_box">
							<div class="autoscroll">
								<table  class="display" id="example" style="margin-top:10px;" >
									<form name="shout_frm" id="shout_frm" method="post">
										<thead>
											<tr style="background-color:rgb(254, 205, 7);">
												<th width="120">Title</th>
												<th>Challenge Start 	</th>
												<th>Challenge End</th>
												 <th>Action</th>
											</tr>
										</thead>
										<tbody>
				<?php
								$i=0;
								if($num=@mysql_num_rows($contests_list)) 
								{
									while($row1 = mysql_fetch_array($contests_list))
									{
									 	if($row1['contest_id'] != "")
									 	{
				?>
											<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
												<td><?php echo $row1['contest_title']; ?></td>
												<td>
													<?php echo  date('F jS  Y',strtotime($row1['contest_start'])); ?>
												</td>
												<td>
													<?php echo  date('F jS  Y',strtotime($row1['contest_end'])); ?>
												</td>
												<td>
													<?php
													if(strtotime($row1['contest_end']) > strtotime(date('Y-m-d H:i:s')))
													{
													if($_SESSION['user_id'] != $row1['user_id']  ){ ?>
													<a href="challenge.php?cont_id=<?php echo $row1['contest_id']; ?>&id=<?php if(isset($_GET['id'])) { echo $_GET['id']; }else{ echo $_SESSION['user_id'];}  ?>">
													<?php if($row1['is_read']=='1'){?>Read<?php }else{ ?>View <?php } ?></a>
													<?php }else { ?>
													<a href="challenge.php?cont_id=<?php echo $row1['contest_id']; ?>&id=<?php if(isset($_GET['id'])) { echo $_GET['id']; }else{ echo $_SESSION['user_id'];}  ?>">View</a>
													<?php } ?>

													<?php  if(!isset($_GET['id']))
													{ ?> 
													<?php if($_SESSION['user_id']==$row1['user_id'])  { ?>
													| 
													<a href="javascript:void(0);" onclick="deletecon('<?php echo $row1['contest_id']; ?>');">Delete</a>
													<?php  }else { ?>
													| <a href="javascript:void(0);" onclick="deletecon_user('<?php echo $row1['contest_id']; ?>');">Ignore</a> 
													<?php } 
													} 
													}
													else
													{
													echo "Challenge Ended";
													}
													?>
												</td>
											</tr>
					<?php
											$i++;
										} 
									} 
								}
								else 
								{ 
						?>
											<tr>
												<td colspan="4" align="center">No challenges added yet</td>
											</tr>
				<?php				}	?>
										</tbody>
									</form>
								</table>
							</div>
					   	</div>  <!-- PROFILE BOX END -->    
  					</div>					
				</div>
			</div>
		</div>
	</article>
	</div>
</div>



<script type="text/javascript">
function goto(url) {

  var w = 500;
  var h = 800;
	
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
  
} 

	//$("#modal_trigger").leanModal({top : 38, overlay : 0.6, closeButton: ".modal_close" });

	$(function(){
		// Calling Login Form
		$("#login_form").click(function(){
			$(".social_login").hide();
			$(".user_login").show();
			return false;
		});

		// Calling Register Form
		$("#register_form").click(function(){
			$(".social_login").hide();
			$(".user_register").show();
			$(".header_title").text('Register');
			return false;
		});

		// Going back to Social Forms
		$(".back_btn").click(function(){
			$(".user_login").hide();
			$(".user_register").hide();
			$(".social_login").show();
			$(".header_title").text('Login');
			return false;
		});

	})
	
</script>
<?php include('Footer.php') ?>