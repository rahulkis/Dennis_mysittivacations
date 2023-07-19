<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
include('HostProfilesHeader.php');
?>

<div class="clear"></div>
<div class="v2_container">
<div class="v2_inner_main">
<div id="hide_sidebar">
<aside class="sidebar v2_sidebar">

<!--<div class="user-profle "> 
<div class="v2_profile_area">
<div class="v2_profile_pic">
<a href="/profile.php"><img src="http://mysitti.com/upload/14283171341428300000test.JPG_thumbnail.JPG" align=""></a>
</div>
  <div class="uname">MidNight</div>
</div>
</div>-->
<div class="side_profile v2_gutter">
<h1><a href="edit_profile.php" style="color: #000;">MidNight Profile</a></h1>
<div class="v2_live_control">
  <div class="v2_webcambutton"> <a onclick="gotoLive('live2/live_broadcast.php?username=MidNight&amp;clubID=7');" class="button" href="javascript:void(0);">Go Live</a> 
    
    <!--echo '<a href="live2" target="blank" class="button">Go Live</a>';--> 
    
  </div>
  <div class="v2_live_stresm_go"> <a onclick="goto1('live2/channel.php?n=MidNight&amp;host_id=7&amp;user_type=user')" name="submit" class="button">Live Streaming <span class="stats_icon"><img title="Offline" alt="Offline" style="width:15px; height:15px;" src="images/offline_u.png?t=1435834631"></span> </a> </div>
</div>
<ul class="v2_nav_right">
<div class="UseroneBox" style="display: none" id="back_none"> <img width="130" height="158" alt="img" src="upload/14283171341428300000test.JPG_thumbnail.JPG"><br>
  <div style="font-size:18px; color:white;"> MidNight </div>
</div>
<!-- END back_none -- >

<ul class="reset listing">
  <!-- <li class="firstheading" id="back_none"> <h4> Profile</h4></li> -->
  <li> <a class="black_text" href="edit_profile.php"> <span>Edit</span> </a> </li>
  <li> <a class="black_text" href="upload_photo.php"> <span>Photos</span> </a> </li>
  <li> <a class="black_text" href="upload_video.php"> <span>Videos</span> </a> </li>
  <!-- <li>  <a href="invite.php" class="black_text"> Invite Friends </a> </li> -->
  <li><a class="black_text" href="profile.php"> <span>Profile Posts</span></a></li>
  <li> <a class="black_text" href="user_shout.php"> <span>Shouts</span> </a> </li>
  <li> <a class="black_text" href="user_challenge.php"> <span>Challenges</span> </a> </li>
  <li style="background: none repeat scroll 0% 0% rgb(224,91,73);"> <a class="users" href="user_social.php">Social Media Sites</a></li>
  <li><a class="black_text" href="downloadtracks.php"> <span>Music Download</span> 
    <!-- <div class="unread downloadscount" style="" >5 </div> --> </a></li>
  <li><a class="black_text" href="downloadpasses.php"> <span>Pass Download</span> </a></li>
  <li><a class="black_text" href="successPurchase.php"> <span>Purchased Tickets</span> 
    <!-- <div class="unread downloadscount" style="" >2 </div> --> </a></li>
  <li> <a class="black_text" href="myCalendar.php"> <span>Calendar</span> </a> </li>
  <!-- <li><a href="reset_password.php" class="black_text"><span>Reset Password</span></a></li> -->
  <li> <a class="black_text" href="userOrderHistory.php"> <span>Order History</span> </a> </li>
</ul>
<div class="clear:both;"></div>
<!--<ul class="reset listing">
					
					
				<li class="firstheading prvtzone"   id="back_none"><div class="prvtzonedv"> <h4 class="prvtzoneh4"> Clique</h4></div></li>
				<li><a href="private_zone.php" class="black_text"> Mid Night </a></li>
				<li><a href="my_private_post.php" class="black_text">Manage Clique Posts </a></li>
				<li><a href="all_friends.php" class="black_text">Clique Permissions </a></li>
			  </ul> -->

<ul class="v2_nav_right">
  <li id="back_none" class="firstheading prvtzone">
    <div class="prvtzonedv">
      <h4 class="prvtzoneh4"> MidNight</h4>
    </div>
  </li>
  <!-- <li>
						<a href="private_zone.php" class="black_text"> <span>Clique</span> </a>
						
					</li> -->
  <li> <a class="black_text" href="user_search.php"> <span>Invite Friends</span> </a> </li>
  <li> <a class="black_text" href="all_friends.php"> <span>Friends List</span> </a> </li>
  <li> <a class="black_text" href="friend_request.php"> <span>Request</span> </a> </li>
  <li> <a class="black_text" href="private_groups.php"> <span>Groups</span> </a> </li>
  <li> <a class="black_text" href="all_hosts.php"> <span>Favourites</span> (18) </a> </li>
</ul>
</div>
</aside>
</div>
<article class="forum_content v2_contentbar">
<div class="v2_rotate_neg">
<div class="v2_rotate_pos">
<div class="v2_inner_main_content">
  <p>Right</p>
  </div>
  </div>
  </div>
  <div class="equalizer">
  </div>
</article>
</div>
<div class="clear"></div>
</div>
<?php 
include('Footer.php');
?>
