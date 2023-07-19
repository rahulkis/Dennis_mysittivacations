<?php
ob_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Friend Request";
include('NewHeadeHost.php');

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

if(!isset($userID)){ $Obj->Redirect($SiteURL); }
?>

<script type="text/javascript">
function isLogin() {
	if (confirm("Please login to view profile. ")) {
	 document.location = "login.php";
	}
}
 function requestAccept(id)
 {
 	$.get('request-accept.php?f_id='+id, function(data) {
		$('#request_'+id).html(data);
 		window.location='all_friends.php';
	});
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
span.seperator {
		float: left;
		margin-right: 10px;
}
</style>
<?php 

if($_SESSION['user_id']!="" )
{
 // $sql4="select f.id as f_id  from  friends as f where f.status='pending' AND f.friend_id='".$_SESSION['user_id']."'";

		$sql4="select distinct(fs.user_id), fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs
		where fs.friend_id='".$_SESSION['user_id']."' AND fs.friend_type = '$_SESSION[user_type]' AND fs.user_id != 1 AND fs.user_id != '$_SESSION[user_id]' AND fs.status  = 'pending'
		GROUP BY friend_id ORDER BY id ASC";

	
}
 $sql6=@mysql_query($sql4);
 $num=@mysql_num_rows($sql6);

?>
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
					<?php include('commonpage.php');?>
					<h3 id="title"><?php echo $_SESSION['profile_name']; ?> Peep Requests </h3>
					 <div style="border-bottom:0px solid #ffffff; padding:5px;"></div>
									
						<?php  
					 // echo $count = mysql_num_rows($sql6);
					 

							if($num==0)
							{
								?>
								<div class="err NoRecordsFound" d="middle" >
								<?php echo "You dont have any friend request"; ?>	
								</div>
													<?php
							}
							else
							{
								?>
													 <div id="middle" >
													 <?php
						
											 while($sql5=@mysql_fetch_array($sql6))
											{

														if($sql5['user_type'] == "user")
														{
															$friendQuery  = mysql_query("SELECT `profilename`,`id`,`is_online`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
																				FROM `user` 
																				WHERE `id` = '$sql5[user_id]'
																			");
															$friendResult = mysql_fetch_assoc($friendQuery);
															if(!empty($friendResult['profilename']) )
															{
																$friendName = $friendResult['profilename'];
															}
															else
															{
																$friendName = $friendResult['first_name']." ".$friendResult['last_name'];
															}

															$friendCityid = $friendResult['city'];
															$friendStateid = $friendResult['state'];
															$friendCountryid = $friendResult['country'];
															$friendID = $friendResult['id'];
															$friendZip = $friendResult['zipcode'];
															$friendSattus = $friendResult['status'];
															$imageSrc = $friendResult['image_nm'];
															$anchorPath =	"profile.php?id=".$friendID;
															$onlineStatus = $friendResult['is_online']; 

														}
														else
														{
															$friendQuery  = mysql_query("SELECT `id`,`is_online`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
																				FROM `clubs` 
																				WHERE `id` = '$sql5[user_id]'
																				AND `non_member` = 0
																			");
															$friendResult = mysql_fetch_assoc($friendQuery);

															$friendName = $friendResult['club_name'];

															$friendCityid = $friendResult['club_city'];
															$friendStateid = $friendResult['club_state'];
															$friendCountryid = $friendResult['club_country'];
															$friendID = $friendResult['id'];
															$friendZip = $friendResult['zip_code'];
															$friendSattus = $friendResult['status'];
															$imageSrc = $friendResult['image_nm'];
															$anchorPath =	"host_profile.php?host_id=".$friendID;
															$onlineStatus = $friendResult['is_online'];
														}

														$countrysql = @mysql_query("SELECT * FROM `country` WHERE country_id = '$friendCountryid' ");
														$countryfetch = @mysql_fetch_array($countrysql);
														$statesql = @mysql_query("SELECT * FROM `zone` WHERE zone_id = '$friendStateid' ");
														$statefetch = @mysql_fetch_array($statesql);
														$citysql = @mysql_query("SELECT * FROM `capital_city` WHERE city_id = '$friendCityid' ");
														$cityfetch = @mysql_fetch_array($citysql);


							?>
									<div class="v2_friend_listing">
											 <div class="infodiv">
						
												<div class="image_friends">
								<?php
															 	if($imageSrc!="")
																{
																 ?>
																	<img src="<?php echo $imageSrc; ?>" alt="" />
																<?php } else { ?>
																<img src="images/man4.jpg"  alt=""/>
																<?php } ?>	
											 </div>
														 <div class="address_friends">
															<?php
																 echo $friendName ."<br/>". $countryfetch['name'] ."<br/>".  $statefetch['name']. "<br/>". $cityfetch['city_name'] . "<br/>";
																	?>
														
														 </div>
								
											<div class='chatoption'>
							<?php if(isset($_SESSION['user_id'])){?> 
							<a href="<?php echo $anchorPath; ?>" class="button-a" > View Profile </a>
							<span id="request_<?php echo $sql5['f_id'];?>">
							<a class="button-a" href="javascript:void(0);" onClick="requestAccept('<?php echo $sql5['f_id'];?>');">Accept</a>
							</span>
							<?php } ?>
							</div>   	
									 </div>	 </div>
										<?php
								
								 }
							}
									?>
											 </div>					
					
				</div>
			</div>
		</div>
	</article>
	</div>
</div>
		<?php include('Footer.php') ?>