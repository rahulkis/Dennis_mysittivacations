<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$titleofpage="Popular Events";

if(isset($_SESSION['user_id']))
{
	//include('LoginHeader.php');
	include('NewHeadeHost.php');

}
else
{
	include('Header.php');	
}

	
if(isset($_SESSION['user_id']))
{
	$sql_city_id=@mysql_query("select * from  clubs where id='".$_SESSION['user_id']."'");
	$city_id2=@mysql_fetch_assoc($sql_city_id);
}
else
{
	$city_id2 = array();
	$city_id2['zipcode']='38125';
}
if(isset($_SESSION['clubs_filter']))
{
	$club_filter=$_SESSION['clubs_filter'];
	unset($_SESSION['clubs_filter']);
	$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";
}else
{
	$cnd=" parrent_id='0'";
}
if($_SESSION['miles'])
{
	$miles_filter=$_SESSION['miles'];
	unset($_SESSION['miles']);
}

$sql_main_club=@mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC");

require_once("admin/paging.php");
?>
<script language="javascript">

function goto(url)
{
	window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=200');
	return false;
}
function goto1(url)
{
	window.open(url,'1396358792239','width=900,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=0');
	return false;
}
function changecity()
{
	var val=$('#city_name').val();
	$.get('set-session.php?city_id='+val, function(data) {
		window.location='searchEvents.php';
	});
}

</script>
<link rel="stylesheet" href="../css/new_portal/smk-accordion.css" />
<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'mysittidev.com');
  ga('send', 'pageview');

</script>
<style type="text/css">
	.custom_slide .live_stream_new {
  		bottom: 24px;
	}
	.custom_slide .live_stream_new a
	{
		background-color: #000;
	}
	.custom_slide .live_stream_new a:hover
	{
		background-color: #fecd07;
		color: #000;
	}
	.custom_slide .live_stream_new a span.stats_icon
	{
		margin: 0;
	}
</style>
<div class="v2_content_wrapper">
  <div class="v2_content_inner_topslider spacer1">
	<div class="topSilder">
	  <div class="fullblack">
		<div class="img_slider_btm">
		  <div class=" ">
			<?php 
			$getAllclubs = mysql_query("SELECT * FROM `clubs` WHERE `non_member` = '0' AND `image_nm` != ''  AND  `deactivate_account` = '0' ORDER BY rand() ");
		?>
			<ul class="bxslider custom_user_slides">
			  <?php
				while($fetchAllclubs = mysql_fetch_array($getAllclubs))
				{
					//print_r($fetchAllclubs);
					$clubEmail = $fetchAllclubs['club_email'];

					$getSubhost = mysql_query("SELECT `id` FROM `hostsubusers` WHERE `useremail` = '$clubEmail' ");

					if(mysql_num_rows($getSubhost) == '0')
					{

						$clubNAme= explode(" ", $fetchAllclubs['club_name']);
						$username_dash_separated = implode("-", $clubNAme);
						$username_dash_separated = clean($username_dash_separated);
						$city_id_club = $fetchAllclubs['club_city'];
						$state_id_club = $fetchAllclubs['club_state'];
							
						$getCity = mysql_query("SELECT `city_name` FROM `capital_city` WHERE `city_id` ='$city_id_club'");			
						$city_name = mysql_fetch_assoc($getCity);
						
						$getState = mysql_query("SELECT `name` FROM `zone` WHERE `zone_id` = '$state_id_club'");			
						$state_name = mysql_fetch_assoc($getState);				
		?>
							  <li class="custom_slide"> 
							  	<span class="city_users"><?php  echo $state_name['name']; ?></span> 
							  	<span class="state_users"><?php echo $city_name['city_name'] ?></span> 
							  	<a href="<?php echo $SiteURL; ?><?php if(isset($_SESSION['user_id'])){ ?>host_profile.php?host_id=<?php echo $fetchAllclubs['id']; }else{ echo $fetchAllclubs['club_name']; }?>"> 
							  		<img  src="<?php echo $SiteURL.$fetchAllclubs['image_nm'];?>" alt="" /> 
							  	</a> 
							  	<!-- <span class="name_users"><?php //echo $username_dash_separated;?></span> -->
								<div class="live_stream_new">
								  <?php
										$mobile = detect_mobile();
										if($mobile === true) { 
										?>
								  <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
								  <?php if(detect_stream($username_dash_separated)===true){ ?>
								  <a class="button" name="submit"  onclick="goto1('https://192.163.248.47:1935/live/<?php echo $username_dash_separated;?>/playlist.m3u8')">Live Streaming <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span> </a>
								  <?php } /*else{ ?>
														  <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
													  <?php } */?>
								  <? } else { ?>
								  <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
								  <?php if(detect_stream($username_dash_separated)===true){ ?>
								  <a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $fetchAllclubs['id']; ?>&user_type=club')">Live Streaming <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span> </a>
								  <?php } 
											  } ?>
								</div>
								<span class="name_users"><?php echo $username_dash_separated;?></span>
							  </li>
			  <?php
					}
				}
		?>
			</ul>
		  </div>
		</div>
	  </div>
	</div>
	<div class="v2_content_inner2">
	 	<?php include('hotSpotsSidebar.php'); ?>
	  <article class="forum_content v2_contentbar">
	  <h3 id="title">Most Popular Events</h3>

	  <script type="text/javascript">
function test()
{
	var cityid = $('.ac_over').find('p').text();

	var club1 = $('.ac_over').html().split('<p');
	$('.ac_over').find('p').remove();
	var club = club1[0];
	var r = /<(\w+)[^>]*>.*<\/\1>/gi;


	setTimeout(function() {
		  // Do something after 5 seconds
			
		var tt = $('#eventsearch').val();
		var tt2 = $('#clubs_autocomplete').val();



			if(tt == "" || tt == " ")
			{

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


					$('#get_clubs_results ul').html(data);

					  }
				   });
			}

	}, 1000);	
}
</script>
	  <?php

$sql = "select forum.event_category,forum.forum, forum.event_id ,forum.event_date,forum.description,forum.event_address,forum.image_thumb,forum.from_user,forum.contest_id,forum.user_type,forum.user_id,forum.forum_id, forum.forum_img,forum.forum_video,forum.status from forum as forum
where forum.status ='1'  AND `forum`.`post_from` = 'city_forum' AND `forum`.`post_count` != '0' GROUP BY forum.forum, forum.event_date  ORDER BY `forum`.`post_count` DESC ";
	$sql1 = @mysql_query($sql);
	$count = @mysql_num_rows($sql1);





	$rowCount = 0;
	$total = 0;
	$total = $count;
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
	}
	else
	{
		$page = '1';
	}
	$limit = '10';  //limit
	$i=$limit*($page-1);
	
	$pager = Pager::getPagerData($total, $limit, $page);
	$offset = $pager->offset;
	$limit  = $pager->limit;
	$page   = $pager->page;
	$sql = $sql . " limit $offset, $limit";
if($count > 0)
{
	$sql = @mysql_query($sql);
	$iiii = 1;
	while($row = @mysql_fetch_array($sql))
	{
	   //echo "<pre>"; print_r($row); die;
		$eventimage = $row['event_category'].".jpg";
		if($row['user_type'] == "club")
		{
			
			$selecthostquery = @mysql_query('SELECT * FROM `clubs` WHERE id = "'.$row['user_id'].'" ');
			$reshostquery = @mysql_fetch_array($selecthostquery);
			$postername = $reshostquery['club_name'];
			$imagesrc = $reshostquery['image_nm'];
			$club_id = $reshostquery['id'];
 			$islaunch = $reshostquery['is_launch'];
			if($_SESSION['user_type'] == "user"){

				$host_details=@mysql_query("select status from  friends where friend_id='".$club_id."' AND user_id='".$_SESSION['user_id']."' AND friend_type='club'");
				$club_dtl=@mysql_fetch_assoc($host_details); 				
				
			}	
			if($imagesrc =="")
			{
				$imagesrc = "images/man1.jpg";
			}
			else
			{ 
				$imagesrc = $imagesrc ;
			
			}
		  
		}
		else
		{
			
			
			
			$postername = $row['first_name']." ".$row['last_name'];
			if($row['image_nm']=="")
			{
				$imagesrc = $SiteURL."images/man1.jpg";
			}
			else
			{ 
				$imagesrc = $SiteURL.$row['image_nm'];
			
			}   
		}
		if($row['from_user'] != '0')
		{
			//echo "SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ";
			$getusersql = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."' ");
			$fetchusersql = @mysql_fetch_array($getusersql);
			//echo "<pre>"; print_r($fetchusersql); die;
			$imagesrc = $SiteURL.$fetchusersql['image_nm'];
			$postername = $fetchusersql['first_name']." ".$fetchusersql['last_name'];
		}

	   ?>
	   <div class="v2_blog_post">
	   <div class="v2_blogpost_user">
		
			<div class="pic">
            	
                <a href="<?php echo $SiteURL; ?><?php if(isset($_SESSION['user_id'])){ ?>host_profile.php?host_id=<?php echo $club_id;  }else{ echo $postername; }?>">
					<?php        
					 if($row['user_id'] == '0')
					 {
							$style = " ";
					 }
					 else
					 {
							echo '<img src="'.$imagesrc.'" />';
							echo $postername;
							$style= "";
					 }


					?>

				
				
				
			</a>
                
                <div class="followdbtn">
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "user" && $row['user_id'] != 0) { ?>
                
                <a style="display: none;" id="block" href="javascript:void(0)" class="button follow_hostc block">Followed</a>
                
                
                <?php if($club_dtl['status']=='active') { ?>
                    <a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
                
          
                <?php }else if($club_dtl['status']=='block') { ?>
                    <a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a>
                 
          
                <?php }else {  ?>
                    <input type="submit" id="request" class="button follow_hostc" value="Follow Host" name="submit" onclick="savehost('<?php echo $club_id;?>','request')">
                <?php } }?>
                
                
                </div>
                <div class="followdbtn align-left">

<?php 
			$pieces = explode(" ", $postername);
        	$username_dash_separated = implode("-", $pieces);
        	$username_dash_separated = clean($username_dash_separated);
           if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "user" && $row['user_id'] != 0 && detect_stream($username_dash_separated)===true){ ?>

            <a class="button" name="submit"  onclick="goto1('live2/channel.php?n=<?php echo $username_dash_separated;?>&host_id=<?php echo $club_id; ?>&user_type=club')">Live Streaming
            <?php // comment by kbihm on 30-01-2015 if($userArray[0]['is_launch']=='1'){?>
            <?php if(detect_stream($username_dash_separated)===true){ ?>
                           <span class="stats_icon" ><img src="images/online_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Online" title="Online" /></span>
                      <?php } else{ ?>
                          <span class="stats_icon" ><img src="images/offline_u.png?t=<?= time() ?>" style="width:15px; height:15px;" alt="Offline" title="Offline" /></span>
                      <?php } ?>                        
            
            </a>

<?php  } ?>

		</div>
        
            </div>		
		
	   </div>
	  <div class="v2_post_container">
		<div  id="forumcontent">
		  <?php $share_img=''; 
		  	if($row["forum_img"]!="" || $row["forum_img"] =="") 
		  	{
	
		  		

		  		if($row['user_id'] == "0")
		  		{
		  			$fullImage = $row['forum_img'];
		  			$thumbImage = $row['image_thumb'];
		  		}
		  		else
		  		{
		  			$fullImage = $SiteURL.str_replace("../", "", $row["forum_img"]);
		  			$thumbImage = $SiteURL.str_replace("../", "", $row["image_thumb"]);
		  		}
	
							
						   
						if(empty($fullImage))
						{
							?>
		  <a href="<?php echo $SiteURL; ?>events_icons/<?php echo $eventimage;?>" rel="lightbox"> 
		  <!-- <img style="width:auto !important;" src="<?php echo $adv_img1; ?>" /> --> 
		  <img  <?php echo $style; ?> src="<?php echo $SiteURL; ?>events_icons/<?php echo $eventimage;?>" alt=""  /> 
		  <!-- <img src="resize.php?w=260&h=200&img=<?php echo $adv_img1; ?>" alt="" /> --> 
		  </a>
		  <?php 

						}
						else
						{


						?>
		  <a href="<?php echo $fullImage; ?>" rel="lightbox"> 
		  <!-- <img style="width:auto !important;" src="<?php echo $adv_img1; ?>" /> --> 
		  <img  <?php echo $style; ?> src="<?php echo $thumbImage; ?>" alt=""  /> 
		  <!-- <img src="resize.php?w=260&h=200&img=<?php echo $adv_img1; ?>" alt="" /> --> 
		  </a>
		  <?php }   $share_img=$fullImage; } ?>
		  <!--<br /><br />-->
		  <?php if($row["forum_video"]!="") { ?>
		  <a href="#dialogx" name="modal">
		  <?php //echo substr($row["forum_video"],3);?>
		  <div id="a<?php echo $row["forum_id"];?>"></div>
		  <script type="text/javascript">
							 jwplayer("a<?php echo $row["forum_id"];?>").setup({
								file: "<?php echo $SiteURL.substr($row["forum_video"],3);?>",
								//file: "Video.MOV",
								height : 140 ,
								width: 200
								});
							</script> 
		  </a>
		  <?php $share_img=$SiteURL.$row["forum_video"]; } ?>
		</div>
		<div class="comment_box commentdisplay">
	  <div class="box2">
		<div class="v2_share_on">
			<?php  if($row["user_id"]=='0'){ $shareurl=$share_img;}else{ $shareurl=$share_img;} ?>
			<a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onclick="return fbs_click('<?php echo $shareurl;?>', 'mysittidev.com' )" target="_blank" style="text-decoration:none;">
				<img src="<?php echo $SiteURL; ?>images/fbook.png" alt="Share on Facebook"/>
			</a> 
			<a href="#" onclick="return fbs_click123('<?php echo $shareurl;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter">
				<img src="<?php echo $SiteURL; ?>images/twt.png" alt="Share on Twitter"/>
			</a> 
			<a href="https://plus.google.com/share?url=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
				<img src="<?php echo $SiteURL; ?>images/g+.png" alt="Share on Google+"/>
			</a> 
	  	</div>
	  </div>
	</div>
	  </div>
	  <div class="v2_post_info">
		<h1> 
		  <!--Added on 15.12.2014-->
		  <?php 
				
						if($row['forum'] == "")
						{
							
$getforumtitlequery = @mysql_query('SELECT * FROM contest WHERE contest_id = "'.$row['contest_id'].'" ');
							$getarray = @mysql_fetch_array($getforumtitlequery);
							if($getarray['host_id'] == "0")
							{
								
								echo "<p> mySitti's ".$getarray['contest_title']." contest</p>";
							}
							else
							{
								
$gethostnamequery = @mysql_query('SELECT * FROM clubs WHERE id = "'.$getarray['host_id'].'" ');
								$gethostarray = @mysql_fetch_array($gethostnamequery);
			 echo "<p>".$gethostarray['club_name']." ".$getarray['contest_title']." contest</p>";
							}
							
						}
						else
						{
							echo "<p>".$row['forum']."</p>";
						}

				?>
		  <!--//Added on 15.12.2014--> 
		  
		</h1>
		<div class="event-date">
		  <?php 
								

					   echo date('F j, Y l g:i A',strtotime($row['event_date'])); ?>
		</div>
		<div class="location"> 
			<span class="post_address">
				<?php echo $row['event_address']; ?>
			</span> 
			<span class="post_map"> 
				<a target="_blank" title="" class="map"  onclick="goto('<?php echo $SiteURL; ?>eventmap.php?add=<?php echo $row['forum_id'];?>');">Map</a>
			</span>
		  <div style="clear:both"></div>
		</div>
		<p class="discription">
		  <?php 
			$des = strip_tags($row['description']);



		$des = str_replace('www.', ' www.', $des);
						echo substr($des,0,200); ?>
		  <?php
			if($row['user_id'] == '0')
			{
				$eid = $row['forum_id'];
			}
			else
			{
				$eid = $row['event_id']."&action=event";
			}
			
			?>
		  <a onClick="javascript:void window.open('<?php echo $SiteURL; ?>read_more_cityevent.php?id=<?php echo $eid; ?>','','width=500,height=700,resizable=true,left=0,top=0');return false;"  >Read More...</a> </p>
	  
			<?php
			if($_SESSION['user_type'] == 'user')
			{   
				$checkuserevent = mysql_query("SELECT `id` FROM `user_events` WHERE `uid` = $_SESSION[user_id] AND `forum_id` = '$row[forum_id]' ");
				$countevent = mysql_num_rows($checkuserevent);
				if($countevent < 1)
				{
				?>
					<div class="box2 addtoMyCalendar" id="add_to_calendar_<?php echo $row['forum_id']; ?>">
						<a href="javascript:void(0);"  id="event_to_calendar" onclick="addToCalendar('<?php echo $row['forum_id']; ?>');"><img src="images/addtoCalendar.png" title="Add to your Calendar" alt="Add to your Calendar"></a>
					</div>
			<?php }
				else
				{
					?>
					<div class="box2 addtoMyCalendar" id="add_to_calendar_<?php echo $row['forum_id']; ?>">
						<span style='color:rgb(254, 205, 7);'>Event Already Added to your Calendar!</span>
					</div>
			<?php 
				}
			
			}
			?>
	  
	  </div>
   
</div>
  <?php 
	$iiii++; }
}
else
{
	echo "<p id='errormessage' style='display:block;'>No Events Yet.</p>";
} 

if(isset($_GET['c'])){
	
	$e_cat = "&c=".$_GET['c'];
}

echo '<div class="pagination">';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1'.$e_cat.'"><span title="First">&laquo;</span></a>';
		if ($page <= 1)
			echo "<span>Previous</span>";
		else            
			//echo "<a href='".$_SERVER['PHP_SELF']."'?page=".($page-1).$e_cat."'><span>Previous</span></a>";
			echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1).$e_cat."'><span>Previous</span></a>";
		echo "  ";
		if(!isset($_GET['page']))
			{
				$y = '1';
			}
			else
			{
				$y = $_GET['page'];
			}
			$z = '0';
			for ($x=$y;$x<=$pager->numPages;$x++){
				
				if($z < 9)
				{
					echo "  ";
					if ($x == $pager->page)
					{
						echo "<span class='active'>$x</span>";
					}
					else
					{
						echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x.$e_cat."'><span>".$x."</span></a>";
					}
				}
				$z++;
			}
		if($page == $pager->numPages) 
			echo "<span>Next</span>";
		else           
			echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1).$e_cat."'><span>Next</span></a>";
								
		echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages.$e_cat."'><span title='Last'>&raquo;</span></a>";
echo "</div>";




		if(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter'])){
		
			$club_filter=$_SESSION['main_clubs_filter'];
			$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";
		
			$sql_main_club=@mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC"); //case 2 :
		
		}else{
		
			$sql_main_club=@mysql_query("select * from club_category where parrent_id='0' ORDER BY name ASC"); //case 1 :
		
		}
		
		$single_sql_main_club=@mysql_query("select * from club_category where parrent_id='0' ORDER BY id ASC"); //case 1 :
		$get_single_club = @mysql_fetch_assoc($single_sql_main_club);
?>

  </article>
</div>
<?php include('Footer.php') ?>
<script type="text/javascript">
function fetchclubs(id)
{
	var catid1 = id.split('_');
	var cityid = "<?php echo $_SESSION['id']; ?>";
	//alert($('#list_'+catid1[1]).size());
	if( $('#list_'+catid1[1]).size()  == 1 )
	{
		$('#list_'+catid1[1]).html('<li style="text-align: center; background: none;"><img width="100px" src="loading.gif" alt="" /></li>');
	}
	
	$.ajax({
		type: "POST",
		url: "fetchClubs.php",
		data: {
			'cityid' : cityid,
			'catid' : catid1[1]
		},
		success: function(data)
		{
			//alert(data);
			$('#list_'+catid1[1]).html(data);
		}
	});
}

function set_default_cat(){
	var atLeastOneIsChecked = $( "#s_default_cat:input:checked" ).val();
	if (atLeastOneIsChecked == "on") {
		
		var cat_value = $('#eventcatselect').val();
		var user_type = '<?php echo $_SESSION['user_type']; ?>';
		var user_id = '<?php echo $_SESSION['user_id']; ?>';
		
		$.ajax({
			type: "POST",
			url: "ajaxcall.php",
			data: {
				'set_default_category' : cat_value, 'user_type' : user_type, 'user_id' : user_id
			},
			success: function(data)
			{
				alert(data);
			}
		});
	}
}

function addToCalendar(fid)
{
	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: 	{
				'action' : 'addtocalendar', 
				'forumID' : fid, 
				// 'user_id' : user_id
			},
		success: function(data){
			$('#add_to_calendar_'+fid).html(data);
		}
	});
}

function savehost(id,ac)
{
	
	$.ajax({
        type: "POST",
        url: "savehost.php",
        data: {
            'host_id' : id,
            'action' : ac,
        },
        success: function(data){
			$('.follow_hostc').hide();
			
			if (data == "success") {
				$('.block_new').hide();
				$('.block').show();
			}else if (data == "blocked") {
				$('.unblock_new').hide();
				$('.unblock').show();
			}else if (data == "unblocked") {
				$('.block_new').hide();
				$('.block').show();
			}
        }
    });

return false;

}
</script>