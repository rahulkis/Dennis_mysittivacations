<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
}

$titleofpage="All hosts";
include('NewHeadeHost.php');


if($_SESSION['user_club'] != '')
{

	$profilename=$loggedin_user_data['club_name'];
	$email=$loggedin_user_data['club_email'];
	$club_address=$loggedin_user_data['club_address'];
	$phone=$loggedin_user_data['club_contact_no']; 
	$country=$loggedin_user_data['club_country'];
	$state=$loggedin_user_data['club_state'];
	$club_city=$loggedin_user_data['club_city'];
	$web_url=$loggedin_user_data['web_url'];
	$zipcode=$loggedin_user_data['zip_code'];
	$google_map_url=$loggedin_user_data['google_map_url'];	
	$image_nm  =$loggedin_user_data['image_nm'];
	$_SESSION['username']=$profilename;
	$_SESSION['img']=$image_nm;
}
else
{

	$profilename=$loggedin_user_data['profilename'];
	$first_name=$loggedin_user_data['first_name']; 
	$last_name=$loggedin_user_data['last_name'];
	$zipcode=$loggedin_user_data['zipcode'];
	$state=$loggedin_user_data['state'];
	$country=$loggedin_user_data['country'];
	if($loggedin_user_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_user_data['DOB'];
	$city=$loggedin_user_data['city'];
	$email=$loggedin_user_data['email'];
	$image_nm=$loggedin_user_data['image_nm'];
	$phone=$loggedin_user_data['phone'];

	$_SESSION['img']=$image_nm;
}
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

	function requestBlock(id,ac,ftype)
	{
		if(confirm('Are you sure you want to remove this friend?'))
		{
			$.get('request-block.php?f_id='+id+'&action='+ac+'&friendtype='+ftype, function(data) {
			//$.get('request-block.php?f_id='+id, function(data) {
				$('#request_'+id).html(data);
			});
		}
	}
</script>

<style>
.login table{
border-collapse:collapse;
text-align:left;
border:1px solid blue;
}
.login table tr td{
border:1px solid blue;
}
.login-div {
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
	color: #fff;
	display: block;
	float: left;
	margin-top: 0;
	padding: 15px 0;
	width: 100%;
}
.hostimage {
	float: left;
	width: 40%;
}
.hostimage > div {
	float: left;
	width: 110px;
}
.viewblockhost {
	float: right;
	width: 45%;
}
</style>
<?php 

if($_SESSION['user_id']!="" )
{
 	$sql4 = "select c.club_address,c.image_nm,c.id,c.club_name,c.is_online,fs.friend_id as f_id,fs.id as FID, fs.chat,fs.friend_type from friends as fs
		left join  clubs as c on(c.id=fs.friend_id) 
		where fs.user_id='".$_SESSION['user_id']."' AND fs.user_type='user' AND c.id != 'NULL' AND  fs.status='active' AND fs.friend_type='club' group by c.id";
}
 $sql6=@mysql_query($sql4);
 $num=@mysql_num_rows($sql6);

?>

<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('friend-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
						<?php include('commonpage.php');?>
  						<h3 id="title"><?php echo $_SESSION['profile_name']; ?> Hot Spots</h3>
  						<div id="middle" style=" border:hidden; min-height:0;" >
						<?php
							if($num > 0)
							{	  
						                 	while($sql5=@mysql_fetch_array($sql6))
						                    	{
							
									$pieces = explode(" ", $sql5['club_name']);
									$username_dash_separated = implode("-", $pieces);
									$username = $username_dash_separated ;
						?>
									<div class="v2_friend_listing" >
                                     <div class="infodiv">
		                 							<div class="image_friends">
		                  								 
							<?php
												if($sql5['image_nm']!="")
												{
									?>
													<a href="host_profile.php?host_id=<?php echo $sql5['id'];?>"><img src="<?php echo $sql5['image_nm']; ?>" alt="" /></a>
							<?php 					}
												else
												{
									?>
													<a href="host_profile.php?host_id=<?php echo $sql5['id'];?>"><img src="images/man4.jpg"  alt="" /></a>
								<?php 				} 	?>	
		                  								</div> 
		                  								<div class="address_friends">
		                   					<?php 				echo $sql5['club_name']  ."<br/>". $sql5['country'] ."<br/>".  $sql5['club_address'] ."<br/>";	   ?>
											</div>
					    					
		                							<div class="delpost">
										<?php 
											if(isset($_SESSION['user_id']))
											{
										?> 
											<!-- <a href="host_profile.php?host_id=<?php echo $sql5['id'];?>" class="button-a"> View Profile </a> -->
											<span id="request_<?php echo $sql5['FID'];?>">
												<a href="javascript:void(0);" onclick=" requestBlock('<?php echo $sql5['FID'];?>','block','<?php echo $sql5['friend_type'];?>');" ><img src="images/del-notification.png" alt="Remove" title="Remove" /></a>
											</span>
							<?php 				} 			?>
										</div>   	
		             						</div></div>
						      <?php 	}  // END WHILE
						      	} // END IF
						      	else
						      	{
						      		echo  '<div class="err" d="middle" >You dont have any friend request	</div>';
						      	}
?>
                 					</div><!-- #middle END-->
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
  
<?php include('Footer.php') ?>
