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
		<ul class="nav_mobile">
            <li><a href="searchEvents.php">City Events</a></li>
            <li><a href="city_talk.php">City Talk</a></li>
            <li><a href="mysitti_contestsList.php">Contest</a></li>
            <li><a href="MySittiTV.php">Mysitti TV</a></li>
        </ul>
			<h1><a  style="color: #000;" href="edit_profile.php"><?php if(($profilename == " ") || ($profilename == "") ) { echo $fullname; }else{ echo $profilename; } ?> Profile</a></h1>

				<div class="v2_live_control">
		  		<div class="v2_webcambutton">
		  			<?php 
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
					<?php if($CheckStream == '0'){ ?>
			                        			<a id="Golivebutton" href="javascript:void(0);" class="button" onclick="gotoLive('live2/live_broadcast.php?username=<?php echo $username_dash_separated; ?>&clubID=<?php echo $_SESSION['user_id']; ?>');">Go Live</a>
		  				<?php 
		  					$CLASS = 'display: none;';
		  				}
		  				else
		  				{
		  					$CLASS = 'display: block;';
		  				}

		  			?>
					<a style="<?php echo $CLASS;?>" id="ViewlivebuttonDesk" class="button" name="submit"  onclick="goto12('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $userID; ?>&user_type=<?php echo $_SESSION['user_type'];?>')">Live Streaming
						<span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
					</a> 
		  				<?php 
		  			}
		  			?>
					
			
		  		<!-- </div> -->
			  	<script type="text/javascript">
					function goto12(url)
					{
						window.open(url,'1396358792239','width=1200,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
						return false;
					}
					function gotoLive(url)
					{
						// alert('sdsdsdsd');
						$('#Golivebutton').hide();
					  	$('#ViewlivebuttonDesk').removeAttr('style');
						window.open(url,'1396358792239','width=1200,height=700,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
						return false;
					}
				</script>
	  		<!-- <div class="v2_live_stresm_go"> -->			
		  </div>
			<span class="talent" style="width:40%;">
				<div class="h">Be Feature?</div> 
				<div class="flatRoundedCheckbox">
					<input type="checkbox" name="" id="flatOneRoundedCheckbox" <?php if($loggedin_user_data['profileType'] == 'Public'){ echo 'checked';}?> >
					<label for="flatOneRoundedCheckbox"></label>
					<div>
						
					</div>
				</div>
			</span>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#flatOneRoundedCheckbox').change(function(){
						
						$.blockUI({ css: {
								border: 'none',
								padding: '15px',
								backgroundColor: '#fecd07',
										'-webkit-border-radius': '10px',
										'-moz-border-radius': '10px',
								opacity: .8,
								color: '#000'
							},
							message: '<h1>Saving Profile Security.</h1>'
						});

						if($('#flatOneRoundedCheckbox').is(':checked'))
						{
							//alert('yes');
							$.ajax({
								type: "POST",
								url: "refreshajax.php",
								data: {
									'action' : 'profileSecurity',
									'value' : 'public',
								},
								success: function(data){
									
									$.unblockUI();
								}
							});
						
						}
						else
						{
							//alert('false');
							$.ajax({
								type: "POST",
								url: "refreshajax.php",
								data: {
									'action' : 'profileSecurity',
									'value' : 'private',
								},
								success: function(data){
									
									$.unblockUI();
								}
							});
						}


						
					});
				});
			</script>
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
         <li class="fordeskonly"> <a href="index.php"> <span data-title="Home">Home</span> </a> </li>
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
     <li class="menuForMobile"><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>
				</ul>
				 
			</div> <!-- here is closing ul and div from profile page-->
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
#suggestedFriends .userIN{
	float: left;
	width: 55%;
}
.userIN p {
	float: left;
	line-height: 30px;
	width: 100%;
	word-wrap: break-word;
}
/*#suggestedFriends ul.tab_scroll
{
	overflow: hidden !important;
	max-height: 500px !important;
}*/
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



	function requestFriend(id, from, to)
	{
		$.get('send-request.php?friend_id='+id+'&from_user_type='+from+'&to_user_type='+to, function(data) {
			$('#request_'+id).html("Requested");
		});
	}


</script>