<?php	
// get friend request

$rq_f=@mysql_query("select id from friends where friend_id='".$_SESSION['user_id']."' AND status='pending'");
$f_req=@mysql_num_rows($rq_f);
// end here 


// get friends list 
$query_string = "select DISTINCT(u.id),u.first_name,u.last_name,fs.friend_id,u.is_online,fs.chat from friends as fs left join user as u on(u.id=fs.friend_id) where fs.user_id='".$_SESSION['user_id']."' AND fs.status='active' AND u.IsAdmin='0'";
$rq_f1=@mysql_query($query_string);
$f_num=@mysql_num_rows($rq_f1);
// end here 

// get clubs
 $query_club = "select c.id,c.club_name,c.is_online,fs.friend_id,fs.chat from friends as fs
 left join  clubs as c on(c.id=fs.friend_id) 
where fs.user_id='".$_SESSION['user_id']."' AND fs.user_type='user' AND c.id != 'NULL' AND fs.status='active' AND fs.friend_type='club' group by c.id";
$rq_club=@mysql_query($query_club);
$f_num_club=@mysql_num_rows($rq_club);
// end here 


$CheckStream = $loggedin_user_data['streamingLaunch'];



?>
<div id="hide_sidebar">
<aside class="sidebar v2_sidebar">
		<div class="side_profile v2_gutter">
			<h1><a  style="color: #000;" href="edit_profile.php"><?php if(($profilename == " ") || ($profilename == "") ) { echo $fullname; }else{ echo $profilename; } ?> Profile</a></h1>

				<div class="v2_live_control">
		  		<div class="v2_webcambutton">
		  			<?php 
		  				/*$data_upgrade_needed=chk_upgrade_needed($data_upgrade['plantype'],"9");
		  				if($data_upgrade_needed)
		  				{
		  					?>
		  					<a href="javascript:void(0);" class="button" onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')">Go Live</a>
		  					<?php
		  				}
		  				else
		  				{ */


		  				
		  			if(empty($profilename))
		  			{
		  				?>
							<a class="button" href="javascript:void(0);" onclick="if(confirm('Please first set up your profilename on edit profile page.')){ window.location.href='edit_profile.php'; }" >Go Live</a>
		  				<?php
		  			}
		  			else
		  			{
	  					$pieces = explode(" ", $profilename);
						$username_dash_separated = implode("-", $pieces);
						$username_dash_separated = clean($username_dash_separated);
		 		?>
				
						<a href="javascript:void(0);" class="button" onclick="gotoLive('live2/live_broadcast.php?username=<?php echo $username_dash_separated; ?>&clubID=<?php echo $_SESSION['user_id']; ?>');">Go Live</a>						
						
		  					<!--echo '<a href="live2" target="blank" class="button">Go Live</a>';-->
		  				<?php //}
		  			}
		  			?>
					
			
		  		</div>
			  	<script type="text/javascript">
					function goto12(url)
					{
						window.open(url,'1396358792239','width=1200,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
						return false;
					}
					function gotoLive(url)
					{
						window.open(url,'1396358792239','width=1200,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
						return false;
					}
				</script>
	  		<div class="v2_live_stresm_go ">
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
					<a class="button mylivestreaming" href="javascript:void(0);" onclick="if(confirm('Please first set up your profilename on edit profile page.')){ window.location.href='edit_profile.php'; }" >Live Streaming</a>
		  <?php
		  		}
		  		else
		  		{
					$mobile = detect_mobile();
					if($mobile === true) 
					{ 
					?>

								<a class="button mylivestreaming" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming
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

								<a class="buttonv mylivestreaming" name="submit"  onclick="goto12('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $_SESSION['user_id'];?>&user_type=user')">Live Streaming
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

			<ul class="v2_nav_right">
				<div id="back_none" style="display: none" class="UseroneBox">
		<?php   if(isset($image_nm) && $image_nm!="")
				{   
		?>
					<img src="<?php echo $image_nm; ?>" width="130" height="158"  alt='img' /><br>
		<?php 
				} 
				else 
				{ 
		?>           
					<a href="/profile.php"> <img src="images/man4.jpg" /></a>
		<?php 
				} 
		?>	
					<div style="font-size:18px; color:white;">  <?php if(($profilename == " ") || ($profilename == "") ) { echo $fullname; }else{ echo $profilename; } ?> </div>  
				</div>  <!-- END back_none -- >  

				<ul class="reset listing">
					<!-- <li class="firstheading" id="back_none"> <h4> Profile</h4></li> -->
         <li class="menuForMobile"> <a href="profile.php" class="white_text"> <span data-title="Home">Home</span> </a> </li>
					<li>  <a href="edit_profile.php" class="black_text"> <span>Edit</span> </a> </li>
					<li> <a href="upload_photo.php" class="black_text"> <span>Photos</span> </a> </li>
					<li>  <a href="upload_video.php" class="black_text"> <span>Videos</span> </a> </li>
					<!-- <li>  <a href="invite.php" class="black_text"> Invite Friends </a> </li> -->
					<li><a href="profile.php" class="black_text"> <span>Profile Posts</a></li>
					<li>
						<a href="user_shout.php" class="black_text"> <span>Shouts</span> </a>
						
					</li>
					<li>
						<a href="user_challenge.php" class="black_text"> <span>Challenges</span> </a>
						
					</li>
					 <li style="">  <a href="user_social.php" class="users"><span>Social Media Sites</span></a></li>
					<li><a href="downloadtracks.php" class="black_text"> <span>Music Download</span>
		 <?         $data=mysql_query("SELECT count(id) as countdownload FROM `purchases` where user_id=".$_SESSION['user_id']);
					$data=mysql_fetch_array($data);
					
		  ?>
					<!-- <div class="unread downloadscount" style="" ><? echo  $data['countdownload'];?> </div> --> </a></li>
					
					
					<li><a href="downloadpasses.php" class="black_text"> <span>Pass Download</span>
					<li><a href="successPurchase.php" class="black_text"> <span>Purchased Tickets</span>
		 <?         $data=mysql_query("SELECT count(id) as countdownload FROM `downloadpasses` where user_id= '".$_SESSION['user_id']."' AND `status` = '0'");
					$data=mysql_fetch_array($data);
					
		  ?>
					<!-- <div class="unread downloadscount" style="" ><? echo  $data['countdownload'];?> </div> --> </li></a>
					<li>  <a href="myCalendar.php" class="black_text"> <span>Calendar</span> </a> </li>
					 <!-- <li><a href="reset_password.php" class="black_text"><span>Reset Password</span></a></li> -->
					<li>  <a href="userOrderHistory.php" class="black_text"> <span>Order History</span> </a> </li>
				</ul>
				<div class="clear:both;"></div>
				<!--<ul class="reset listing">
					
					
				<li class="firstheading prvtzone"   id="back_none"><div class="prvtzonedv"> <h4 class="prvtzoneh4"> Clique</h4></div></li>
				<li><a href="private_zone.php" class="black_text"> <?php echo $fullname; ?> </a></li>
				<li><a href="my_private_post.php" class="black_text">Manage Clique Posts </a></li>
				<li><a href="all_friends.php" class="black_text">Clique Permissions </a></li>
			  </ul> -->
				
				<ul class="v2_nav_right">
					<li class="firstheading prvtzone"   id="back_none">
						<div class="prvtzonedv"> 
						  <h4 class="prvtzoneh4"> <?php if(($profilename == " ") || ($profilename == "") ) { echo $fullname; }else{ echo $profilename; } ?></h4>
						</div>
					</li>
					<li>
						<a href="all_friends.php" class="black_text"> <span>Friends</span> </a>
					</li>
     <li class="menuForMobile logout"><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>
				</ul>
				 
			</div> <!-- here is closing ul and div from profile page-->
	</aside>
</div>
<script type="text/javascript">
	$(document).ready(function(){
			
		$( "#searchUsers" ).keypress(function() {
			var url = $('#siteURL').val();

			var URL = url+'refreshajax.php?action=fetchusernames';
			$('#searchUsers').autocomplete(URL);

		});


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

	});
</script>
