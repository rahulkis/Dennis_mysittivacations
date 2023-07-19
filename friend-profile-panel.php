<?php	
// get friend request
$rq_f=@mysql_query("select id from friends where friend_id='".$_SESSION['user_id']."' AND status='pending'");
$f_req=@mysql_num_rows($rq_f);
// end here 

$myquery = @mysql_query("SELECT * FROM `user` WHERE id ='".$_GET['id']."'  ");
$getchuser = @mysql_fetch_array($myquery);
$profilename = $getchuser['profilename'];
$pieces = explode(" ", $profilename);
$username_dash_separated = implode("-", $pieces);
$n = clean($username_dash_separated);

$CheckStream = $getchuser['streamingLaunch'];


?>
<div id="hide_sidebar">
<aside class="sidebar">
<div class="profileleft">
<div class="side_profile v2_frnds_sidebar">    
			<h1>Profile</h1>
			<script type="text/javascript">
					function goto1(url)
					{
						window.open(url,'1396358792239','width=1200,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
						return false;
					}
				</script>
			 
<div  class="UseroneBox">
	<?php if($getchuser['image_nm']!="")
	{   ?>
		<a href="/profile.php?id=<?php echo $_GET['id'];?>"> <img src="<?php echo $getchuser['image_nm']; ?>" width="130" height="158"  alt='img' /></a>
	<?php 
	} 
	else 
	{ ?>           
		<a href="/profile.php?id=<?php echo $_GET['id'];?>"> <img src="images/man4.jpg" /></a>
	<?php 
	} ?>	
		<div class="uname" style="font-size:18px; color:white;">  <?php echo $getchuser['first_name']." ".$getchuser['last_name']; ?> </div>
	</div><div class="clear"></div>
		<div class="unblockalgn">
			<div class="blockhostbutton" style="float: none ! important; width: 100% ! important;">
			<?php 
				/*$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"9");
				if($data_upgrade_needed)
				{
					?>
					<a href="javascript:void(0);" class="button" onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')">Live Streaming</a>
					<?php
				}
				else
				{
			*/
				if(empty($profilename))
				{
			?>
					<a class="button" href="javascript:void(0);" onclick="if(confirm('Please first set up your profilename on edit profile page.')){ window.location.href='edit_profile.php'; }" >Live Streaming</a>
		  <?php
				}
				else
				{
					$mobile = detect_mobile();
					if($mobile === true) 
					{ 
					?>

								<a class="button" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $n;?>/playlist.m3u8')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
								<?php if($CheckStream == '1'){ ?>
											   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
										  <?php } else{ ?>
											  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
										  <?php } ?>                     	
								
								</a> 
			<? 		}
					else
					{
		?>

								<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $n;?>&host_id=<?php echo $_GET['id'];?>&user_type=user')">Live Streaming
								<?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
								<?php if($CheckStream == '1'){ ?>
											   <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
										  <?php } else{ ?>
											  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
										  <?php } ?>                     	
								
								</a>
		<?php 			}
				}  
			?>			
		  </div>
		</div>
  
  		<div class="searchBoxMobile">
	<div class="searchMobile">
		<form method="POST" action="<?php echo $SiteURL."searchUsers.php";?>" id="searchUsersForm">
		<input type="text" id="searchUsers" value="" name="keyword_search" placeholder="Search By Username" class="adSearchmob">
		<input type="submit" id="findContestant" class="searchBoxTopBtn" name="SearchAllUsers" value="">
	</form>
	</div>
</div>
					<ul class="reset listing v2_nav_right">
						<li><a href="profile.php?id=<?php  echo $_GET['id']; ?>"> Profile </a> </li>
						<li>  <a href="upload_photo.php?id=<?php  echo $_GET['id']; ?>"> Photos </a></li>
						<li>  <a href="upload_video.php?id=<?php  echo $_GET['id']; ?>"> Videos </a></li>
						<li>  <a href="all_friends.php?id=<?php  echo $_GET['id']; ?>"> Friends </a></li>
						   <? 
						  
						/*   $rq_f=@mysql_query("select id from friends where user_id='".$_GET['id']."' AND friend_id='".$_SESSION['user_id']."' AND status='active'  AND  close_friend='1'");
							  $f_req=@mysql_num_rows($rq_f);
							  if($f_req){
							   ?>
							<li><a href="private_zone.php?id=<?php  echo $_GET['id']; ?>">	Clique </a> </li>
							<? }else{ ?>
							<li> <a href="javascript:void(0);" onclick="javascript:alert('You are not allow to view my Clique page');" >Clique <span class="lockimage"><img src="images/lock.png"></span></a></li>
							<?php } */?>
						  <li>  <a href="user_challenge.php?id=<?php  echo $_GET['id']; ?>"> Challenge </a></li>

						  
					</ul>
				
				</div>
		</div>
		<div class="adver" id="leaderboard">
	 		<h1>People You May Know</h1>
	 		<style type="text/css">
#suggestedFriends .userDP {
	float: left;
	width: 40%;
}
#suggestedFriends .userDP > img {
	float: left;
	max-width: 65%;
	width: 65%;
}
#suggestedFriends .userIN {
	float: left;
	width: 55%;
}
.userIN p {
	float: left;
	line-height: 30px;
	width: 100%;
	word-wrap: break-word;
}

 			</style>
	 		<?php 
	 			$getAllUserList = mysql_query("SELECT * FROM `user` WHERE `id` != '1' AND `id` != '1269' AND `image_nm` != '' AND `image_nm` != 'NULL' AND `city` != 'NULL' AND `city` != '' AND `state` != '' ORDER BY RAND() ");

	 		?>
	 		<div class="online_user" id="suggestedFriends" style="height: 500px; overflow-y: scroll;">
				<ul class="">
					<?php 
						while($res = mysql_fetch_assoc($getAllUserList))
						{
							$uID = $res['id'];
							$checkFriend = mysql_query("SELECT * FROM `friends` WHERE `user_id` = '$uID' AND `user_type` = 'user' AND `friend_id` = '$_SESSION[user_id]' AND `friend_type` = '$_SESSION[user_type]' ");
							if(mysql_num_rows($checkFriend) < 1)
							{
								$checkFriend1 = mysql_query("SELECT * FROM `friends` WHERE `friend_id` = '$uID' AND `friend_type` = 'user' AND `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' ");
								if(mysql_num_rows($checkFriend1) < 1)
								{
									?>
										<li style="background: none; float: left; width:90%;">
											<span class="userDP">
												<?php 
													if(empty($res['image_nm']))
													{
														$imgSRC = $SiteURL.'images/man4.jpg';
													}
													else
													{
														$imgSRC = $SiteURL.$res['image_nm'];
													}
													if(empty($res['profilename']))
													{
														$DisplaName = $res['first_name'].' '.$res['last_name'];
													}
													else
													{
														$DisplaName = $res['profilename'];
													}

													$getCityName = mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '$res[city]'");
													$fetchResult = mysql_fetch_assoc($getCityName);

													$getStateName = mysql_query("SELECT * FROM `zone` WHERE `zone_id` = '$res[state]'");
													$fetchResultState = mysql_fetch_assoc($getStateName);

												?>
												<a target="_blank" href="<?php echo $SiteURL.'profile.php?id='.$uID;?>">
													<img src="<?php echo $imgSRC; ?>">
												</a>
											</span>
											<span class="userIN">
												<p class="userNAme">
													<a target="_blank" href="<?php echo $SiteURL.'profile.php?id='.$uID;?>">
														<?php echo $DisplaName; ?>
													</a>
												</p>
												<?php 
													if(!empty($res['city']))
													{
												?>
														<p class="userAddress"><?php echo $fetchResult['city_name'],', '.$fetchResultState['code'];?></p>
												<?php 	}	?>
												<p>
													<a id='request_<?php echo $res['id'];?>' class="button" href="javascript:void(0);" onclick="requestFriend('<?php echo $res['id'];?>', '<?php echo $_SESSION['user_type']; ?>' , '<?php echo 'user'; ?>');" >
														Send Request
													</a>
												</p>
												
											</span>
										</li>
									<?php
								}
							}
					?>		
					<?php 
						}
					?>
		  		</ul>
		  	</div>
		</div>
   	</aside>
</div>


<script type="text/javascript">
	$(document).ready(function(){
			
		$( "#searchUsers" ).keypress(function() {
			var url = $('#siteURL').val();

			var URL = url+'refreshajax.php?action=fetchusernames';
			$('#searchUsers').autocomplete(URL);

		});
	});
	 	function requestFriend(id, from, to)
		{
			$.get('send-request.php?friend_id='+id+'&from_user_type='+from+'&to_user_type='+to, function(data) {
				$('#request_'+id).html("Requested");
			});
		}

		function test()

		{

			var cityid = $('.ac_over').find('p').text();



			var club1 = $('.ac_over').html().split('<p');

			$('.ac_over').find('p').remove();

			var club = club1[0];

			var r = /<(\w+)[^>]*>.*<\/\1>/gi;

			var url = $('#siteURL').val();

			

			setTimeout(function() {

				  // Do something after 5 seconds

					

				var tt = $('#eventsearch').val();

				var tt2 = $('#clubs_autocomplete').val();







					if(tt == "" || tt == " ")

					{

						$.blockUI({ css: {

							border: 'none',

							padding: '15px',

							backgroundColor: '#fecd07',

							'-webkit-border-radius': '10px',

							'-moz-border-radius': '10px',

							opacity: .8,

							color: '#000'

						},

						message: '<h1>Loading Results</h1>'

						});

						$('#clubs_autocomplete').text(club);

						$.ajax({

						type: "POST",

						url: "refreshajax.php",

						data: {

						'fetchresult' : 'fetchresult',

						'clubname' : club,

						'city' : cityid,

						},

							success: function(data){

								$('#get_clubs_results ul').empty();

		 						//$('#get_clubs_results ul').html(data);

		 						document.location.href = data;

								return false;

							}

						   });

					}



			}, 1000);	

		}
</script>