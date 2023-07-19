<?php  //die('dfdfdf')
if(isset($_SESSION['subuser']))
{
	$hostID = $_SESSION['user_id'];
}
elseif(isset($_GET['uid']))
{
	$hostID = $_GET['uid'];
}
else
{
	$hostID = $_GET['host_id'];	
}

$sql = "select * from `clubs` where `id` = '".$hostID."'";
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

if(!empty($_POST['state']))
{	$state = $_POST['state'];
	$city = $_POST['city'];
	$_SESSION['state'] = $_POST['state'];
	$_SESSION['id'] = $_POST['city'];
	$sql="SELECT * FROM `contest` where `status`='1' and contest_city='".$city."' ORDER BY `contest_id` AND user_id = 0 AND host_id = '$userID' DESC limit 1";
}
else{
	$cityid = $_SESSION['id'];
	$date = date('Y-m-d');
 	$sql="SELECT * FROM `contest` where `status`='1' AND `contest_end` > '$date'  AND contest_city='".$cityid."'  ORDER BY `contest_id` AND host_id = '$userID' AND user_id = 0 DESC limit 1";
}

$q = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$userArray[0]['club_name']."'  ");
$f = @mysql_fetch_array($q);


$clubquery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$f['host_id']."'  ");
$fetchclubquery = @mysql_fetch_array($clubquery);


$username_dash_separated = implode("-", $pieces);
$username_dash_separated = clean($username_dash_separated);


?>
<style type="text/css">
          		#leaderboard
          		{
          			float: left;
          			width: 100% !important;
          			margin-top: 0 !important;
          		}
          		#leaderboard h1:before
          		{
				    background-image: url("../../images/siderbar_top.png") ;
				    background-repeat: no-repeat;
				    content: "";
				    float: left;
				    height: 30px;
				    left: 0;
				    position: absolute;
				    top: -30px;
				    width: 100%; 	 
				    font-size: 22px;
    				padding: 14px 0;
				}
				#leaderboard h1
				{

				    background: none repeat scroll 0 0 #FECD07;
				    font-size: 22px;
				    padding: 14px 5px;
				    text-transform: uppercase;
				}
				#leaderboard ul li
				{
				   	color: #FFFFFF;
				    background-position: 6% center;
				    background-repeat: no-repeat;
				    border-bottom: 1px solid #808080;
				    float: left;
				    line-height: 38px;
				    padding: 10px 20%;
				    width: 60%;
				}
          		</style>
<div id="hide_sidebar">
 <aside class="sidebar v2_sidebar">
            <div class="user-profle" style="display: none;">
            	<div style="font-size: 18px; color: white; float: left; width: 100%; margin-top: 10%;">  
            		<?php echo $userArray[0]['club_name']; ?>
        		</div>
        		<div class="hostsideimage">
					
						<? 
						if(($_SESSION['user_type'] == 'user') )
	            			{	
	            				$anchor = "host_profile.php?host_id=".$fetchclubquery['id'];
	            			}
	            			elseif ( isset($_SESSION['subuser'])) 
	            			{
								$anchor = "musicrequestList.php";
	            			}
	            			else
	            			{
	            				$anchor = 'home_club.php';
	            				
	            			}

						if($_SESSION['img']!="")
					 	{ 
						?>
						  <a href="<?php echo $anchor; ?>"><img src="<?php echo $_SESSION['img']; ?>" height="157" width="135" /></a><br />
						 <?php } else { ?>
						   <a href="<?php echo $anchor; ?>"><img src="images/man4.jpg"></a>
					 	<?php } ?>	
	            	
	            </div>
	            <div class="hostaddress">
	            	<?php 
	            		

	            		if((!isset($_SESSION['subuser'])) || ($_SESSION['user_type'] == 'user') )
	            		{
	            	?>
							<span class="subusersidebarlink" style="color: #FFF;">Return to<a style="color:rgb(254, 205, 7);" href="<?php echo $anchor; ?>"> <?php echo $fetchclubquery['club_name']; ?></a></span>
				<?php 	}

						if(isset($_SESSION['subuser']))
						{
							?>
							<span class="subusersidebarlink" style="color: #FFF;">Visit my page:  <a style="color:rgb(254, 205, 7);" href="<?php echo $f['profile_link']; ?>"> <?php echo $f['profilename']; ?></a></span>
				<?php 
						}

				 ?>

	            </div>
            	
 
            </div>
            
        <div class="side_profile">    
            <h1><?php //echo $club_name; ?> Sounds</h1>
            <!-- <div class="unblockalgn">
				<div class="webcambutton">
					<a href="javascript: void(0);" onclick="goto('live2')" class="button">Launch Web cam</a>
				</div>
        	</div> -->
			
			
            <div class="v2_live_control">
          <div class="v2_webcambutton">
	
							
				<?php if(detect_stream($username_dash_separated)===false && !isset($_GET['host_id'])){ ?>
			                        			<a id="Golivebutton" href="javascript:void(0);" class="button" onclick="gotoLive('live2/live_broadcast.php?username=<?php echo $username_dash_separated; ?>&clubID=<?php echo $_SESSION['user_id']; ?>');">Go Live</a>
		  				<?php }

		  			?>
					<a style="display:none;" id="Viewlivebutton" class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $userID; ?>&user_type=club')">Live Streaming
						<span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
					</a> 
            
            
          <!-- </div> -->
          <script type="text/javascript">
	         	function gotoLive(url)
		{
			window.open(url,'1396358792239','width=1200,height=650,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
			document.getElementById('Golivebutton').style.display = 'none';
			document.getElementById('Viewlivebutton').style.display = 'block';
			return false;
		}
		function goto1(url)
		{
			window.open(url,'1396358792239','width=900,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');
			return false;
		}
	</script>
          <!-- <div class="v2_live_stresm_go"> -->
			
			
<?php			
$mobile = detect_mobile();
if($mobile === true) 
{
	if(detect_stream($username_dash_separated)===true || isset($_GET['host_id']))
	{  
?>

	          	<a class="button" name="submit"  onclick="goto1('https://54.174.85.75:1935/httplive/<?php echo $username_dash_separated;?>/playlist.m3u8')">View Streaming
	            <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
	             <?php if(detect_stream($username_dash_separated)===true){ ?>
	                           <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
	                      <?php } else{ ?>
	                          <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
	                      <?php } ?>                     	
	          	
	          	</a> 
 
 

<? 	}
} 
else 
{ 
	if(detect_stream($username_dash_separated)===true || isset($_GET['host_id']))
	{ 
?>

	          	<a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $_GET['host_id']?>&user_type=club')">View Streaming
	            <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
	            <?php if(detect_stream($username_dash_separated)===true){ ?>
	                           <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
	                      <?php } else{ ?>
	                          <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
	                      <?php } ?>                     	
	          	
	          	</a>

<?php 	}
}
 ?>					
			
		
          </div>
        </div>			
			
			<div class="searchBoxMobile ">
	<div class="searchMobile">
		<form method="POST" action="<?php echo $SiteURL."searchUsers.php";?>" id="searchUsersForm">
		<input type="text" id="searchUsers" value="" name="keyword_search" placeholder="Search By Username" class="adSearchmob">
		<input type="submit" id="findContestant" class="searchBoxTopBtn" name="SearchAllUsers" value="">
	</form>
	</div>
</div>
			
            <ul class="v2_nav_right">
            	<!--<li>
        		<?php 

        			$getsubuserquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$club_name."' ");

					$fetchsubuser1 = @mysql_fetch_array($getsubuserquery);
					$fetchsubusercount = @mysql_num_rows($getsubuserquery);
            		if(isset($_SESSION['subuser']))
        			{
        		?>
	            		<a href="live2/" target="_blank">Launch Web cam</a>
        		<?php 
        			}
        			else
        			{
				?>
        				<a href="live2/channel.php?n=<?php echo $club_name; ?>" target="blank" >Live Web cam</a>

			<?php 
        			}


            		?>
				</li>-->
    	<?php
			if(!isset($_SESSION['subuser']))
			{
		?>
            	<li>
            		<a href="musicrequestList.php?uid=<?php echo $hostID; ?>"> Music Requests</a>
            	</li>
<?php 		} ?>
	<li class="menuForMobile"> 
		<a href="<?php if($_SESSION['user_type'] == 'club'){ echo $SiteURL.'home_club.php'; }else{ echo $SiteURL.'profile.php';} ?>" class="black_text"> 
			<span data-title="Home">Home</span> 
		</a> 
	</li>
            	<li>
            		<?php
            			if(isset($_SESSION['subuser']))
            			{
            				?>
            					<a href="shout.php"> Shout Out</a>
            				<?php 

            			}
            			else
            			{
            			/*	if(isset($_GET['uid']))
            				{
            					$uid = $_GET['uid'];
            				}
            				else
            				{
            					$uid = $hostID;
            				}
							$fetchhostquery = @mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$uid."' ");
							$fetres = @mysql_fetch_array($fetchhostquery);
							$getsubuserquery = @mysql_query("SELECT * FROM `hostsubusers` WHERE `username` = '".$fetres['club_name']."' ");
							$fetchsubuser = @mysql_fetch_array($getsubuserquery);
							?>
            					<a href="host_shout.php?host_id=<?php echo $fetchsubuser['host_id']; ?>"> Shouts</a>
            				<?php */
            			}

            		 ?>
            		
            	</li>
            	<?php if(isset($_SESSION['subuser'])) { ?>
              
              	<li  class="menuForMobile"><a href="<?php echo $SiteURL;?>mysitti_contestsList.php"> Contests</a></li>
               <li  class="menuForMobile"><a href="searchEvents.php"> City Events</a></li>
  	<li  class="menuForMobile"><a href="city_talk.php"> City Talk</a></li>
            	<li><a href="music_request.php?host_id=<?php echo $hostID; ?>">View Jukebox</a></li>
            	<li><a href="musicrequestList.php"> Music Request</a></li>
	<li><a href="settingslist.php"> Settings</a></li>
	<li><a href="musicplaylists.php"> Play List</a></li>
	<li class="menuForMobile logout"><a href="<?php echo $SiteURL; ?>main/logout.php"><span data-title="Logout">Logout</span></a></li>  
 
            	<?php } ?>

            </ul>
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