<? $sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ; 
$first_name=$userArray[0]['club_name']; 
$zipcode=$userArray[0]['zip_code'];
$state=$userArray[0]['club_state'];
$country=$userArray[0]['club_country'];
$city=$userArray[0]['club_city'];

$email=$userArray[0]['club_email'];
$image_nm=$userArray[0]['image_nm'];
$phone=$userArray[0]['club_contact_no'];
if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];

$club_address=$userArray[0]['club_address'];
$web_url=$userArray[0]['web_url'];
$club_city=$userArray[0]['club_city'];
$club_name=$userArray[0]['club_name'];
$type_of_club =$userArray[0]['type_of_club'];
$type_details_of_club=$userArray[0]['type_details_of_club'];
$google_map_url=$userArray[0]['google_map_url'];

$q_stat=mysql_query("select name,code from zone where zone_id='$state'");	
$q_res_stat = mysql_fetch_array($q_stat);
$stat_ans=$q_res_stat['code'];

$q_city=mysql_query("select city_name,city_id  from capital_city where city_id='$club_city'");	
$q_res_city = mysql_fetch_array($q_city);
$city_ans=$q_res_city['city_name'];
$pieces = explode(" ", $userArray[0]['club_name']);
$username_dash_separated = implode("-", $pieces);
?>
 <aside class="sidebar">
            <div class="user-profle">
              <img src="images/user_pro.png">
            </div>
            
        <div class="side_profile">    
            <h1>Profile</h1>
            <ul>
						<li>  <a href="edit_profile.php"> Edit </a> </li>
						<li> <a href="upload_photo.php"> Photos </a> </li>
						<li>  <a href="upload_video.php"> Video </a> </li>
						<li> <a href="host_coupon.php"> Upload Pass </a>  </li>
						<li> <a href="host_advertise.php"> Advertisement</a>  </li>
						<li><a href="add_shout.php"> Shout Out</a></li>
						<?php if($type_of_club==11){?>
						<li><a href="listevent.php"> Upcoming Events</a></li>
						<li><a href="eventscalendar.php"> Calendar</a></li>
						<?
						}if($type_of_club==10){ ?>
						<li><a href="listvenue.php"> Upcoming Venues</a></li>
						<li><a href="venuecalendar.php"> Calendar</a></li>
						<? }?>
						<li><a href="bookings.php"> Bookings</a><a href="bookings.php"><?php if($_SESSION['notification']>0){ ?><div class="unread fl" style="position: relative; right: 12px; bottom: 23px; float: right;"> <?php /*echo $ur_con_s;*/  echo $_SESSION['notification']; ?>  </div><?php } ?></a> <?php //} ?></li>
						<li><a href="bookingstype.php"> Booking Types</a></li>
						<li><a href="musicrequestlist.php"> Music Request</a></li>
						<li><a href="music.php"> Load Music</a></li>
						<li><a href="cds.php"> Load CDs</a></li>
            </ul>
      </div>
						<?php	
						// get friend request
						$rq_f=@mysql_query("select id from friends where friend_id='".$_SESSION['user_id']."' AND status='pending'");
						$f_req=@mysql_num_rows($rq_f);
						// end here 
						$query_string = "select u.id,u.first_name,u.last_name,fs.friend_id,u.is_online from friends as fs 
						left join user as u on(u.id=fs.friend_id)
						where fs.user_id='".$_SESSION['user_id']."' AND fs.friend_type='user' AND fs.status='active'";
						$rq_f=@mysql_query($query_string);

						$f_num=@mysql_num_rows($rq_f);
						?>  
       <div class="Connections">    
            <h1>Connections(9)</h1>
            
            <div class="online">
				      <?
				       while($f_req_a=@mysql_fetch_array($rq_f)) 
	                   {
						   echo $f_req_a['is_online'];
						   ?>
                 <ul>
                      <li style='url("../../images/<?php if($f_req_a['is_online']=='1'){ ?>green.png <?php }else{ ?>green.png<?php } ?>")'>
                      <a id="user_live"  href="profile.php?id=<?php echo $f_req_a['id']; ?>" ><?php echo $f_req_a['first_name']?></a></li>
                     <?php if($f_req_a['is_online']=='1'){ ?>
                      <li> <a href="javascript:void(0);"  onclick="sendsession('<?php echo $f_req_a['id']; ?>');"><img src="images/face.png"></a></li>
			          <li></li><a href="javascript:void(0);"   onclick="chatWith('<?php echo $username; ?>');"><img src="images/chat.png"></a></li>
                      <? }else{?>
						 
						  
					  <? }?>
                   </ul>
                     <? } ?>                   
                    <div class="view_more"><a  onclick="window.location='all_connections.php'">View All</a></div>
                    <div class="cam"><a name="submit"  onclick="goto('live/channel.php?n=<?php echo $username_dash_separated;?>')">view web cam</a></div>
                   
            </div>
      </div>
      
      </aside>
