<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="admin_app")
	{
		$message="Your Forum Posted Sucessfully";
	}
}
$titleofpage=" Talk of the town";

$city_name_query = @mysql_query("SELECT * FROM capital_city WHERE city_id = '".$_SESSION['id']."'");
$get_city_name = mysql_fetch_assoc($city_name_query);
$dropdown_city = $get_city_name['city_name'];
?>
  
<?php


if(isset($_SESSION['user_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('Header.php');	
}

if(!isset($_SESSION['user_id'])) { ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".socialfixed").css("display", "none");
		});
	</script>
<?php }

	if(isset($_SESSION['user_id']))
	{
		$sql_city_id=@mysql_query("select * from  clubs where id='".$_SESSION['user_id']."'");
		$city_id2=@mysql_fetch_assoc($sql_city_id);
	} else
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

<?php

if($_POST['update']){
	if(!empty($_POST['thumbnailPhoto']) || !empty($_POST['postVideo']) || !empty($_POST['FullPhoto']) || !empty($_POST['postVideoURL']))
	{
				
			$forum=mysql_real_escape_string($_POST['forum']);
			$forum_img=$_POST['thumbnailPhoto'];
			$forum_video= "";
			$file = $_POST['FullPhoto'];
			if(!empty($_POST['postVideo']))
			{
				$forum_video=$_POST['postVideo'];
			}
			elseif(!empty($_POST['postVideoURL']))
			{
				$forum_video=$_POST['postVideoURL'];
			}
			
			$user_id=$_SESSION['user_id'];
			$added_on=date("Y-m-d h:i:s");
			$status=1;
			
			$ThisPageTable='forum';	

			$forum = mysql_real_escape_string($_POST['forum']);
			$added_on = date("Y-m-d");
		
			mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."', forum_img = '".$file."', image_thumb = '".$forum_img."', forum_video = '".$forum_video."' WHERE user_id != '0' AND forum_id = '".$_POST['forum_id']."'");

			$_SESSION['popup_add_post'] = "updated";

		
	}
	else
	{
		
		$forum = mysql_real_escape_string($_POST['forum']);
		$added_on=date("Y-m-d");
		
		mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."' WHERE common_identifier = '".$_POST['common_identifier']."' AND user_id != '0' AND forum_id = '".$_POST['forum_id']."'");
		$_SESSION['popup_add_post'] = "updated";
	}
	
}


if($_POST['submit'])
{
	$forum=mysql_real_escape_string($_POST['forum']);
	$forum_img=$_POST['thumbnailPhoto'];
	$forum_video= "";
	$file = $_POST['FullPhoto'];
	if(!empty($_POST['postVideo']))
	{
		$forum_video=$_POST['postVideo'];
	}
	elseif(!empty($_POST['postVideoURL']))
	{
		$forum_video=$_POST['postVideoURL'];
	}
	
	$user_id=$_SESSION['user_id'];
	$added_on =date("Y-m-d");
	$status=1;
	$ThisPageTable='forum';
	
	$user_id = $_SESSION['user_id'];
	$user_type = $_SESSION['user_type'];
	$city = $_SESSION['id'];
	$state = $_SESSION['state'];
	$country = $_SESSION['country'];

$common_identifier = date('YmdHis');
	mysql_query("INSERT INTO forum (`forum`, `forum_img`, `image_thumb`, `forum_video`, `user_id`, `added_on`, `city_id`, `state_id`, `country_id`, `status`, `user_type`, `from_user`, `post_from`, `forum_type`,`common_identifier`) VALUES ('".$forum."', '".$file."', '".$forum_img."', '".$forum_video."', '".$user_id."', '".$added_on."', '".$city."', '".$state."', '".$country."', '".$status."', '".$user_type."', '".$user_id."', 'city_talk', 'public','$common_identifier')");
	$_SESSION['popup_add_post'] = "added";  
} ?>


<style>
aside.sidebar{width:27%!important}.adRightBar{width:23%}.travel_menu li ul{display:none}.followdbtn{width:0!important;margin:0!important}.thumb_user_profile{width:65px!important}a.commentuser{text-decoration:none}.label_comment:hover{background:#89a7e5;color:#fff!important}.label_comment{border:1px solid #777;color:#1c50b3!important;padding:8px;float:right}

#popupUpload,.b-modal{background:#000;display:none;position:fixed}.innerCurrentCity1{margin-top:0;text-align:center;width:75%}.v2_banner_top1.h_auto .bx-viewport{height:auto!important}.v2_banner_top1.h_auto ul.new_height{height:402px!important;overflow:hidden}.SharingFriendslist>li{line-height:20px}#mycontent122>.button{float:left;width:10%;margin:0 30%}#mycontent122 input{float:left;width:90%}#mycontent122 p{float:left;margin:5px 0!important;width:100%}#mycontent122 label{float:left;margin:5px 0;width:100%}#popupUpload #mycontent122>div{float:left;margin:10px 0;width:100%}#popupUpload>div#mycontent122{color:#fff;float:left;padding:20px;width:100%}#popupUpload h1{color:#fecd07;float:left;font-size:20px;width:100%;text-decoration:underline;font-weight:700;margin:15px 0}#popupUpload span#close{float:right;margin:10px;color:#fff;font-weight:700}#popup,.bMulti{background-color:#000;border-radius:10px;color:#111;padding:25px;display:none}#popupUpload span.b-close{border:none;float:right;min-width:auto!important}.b-modal{left:0;top:0;height:100%;z-index:99;opacity:.5;filter:alpha(opacity=50);zoom:1;width:100%}#popupUpload{border:5px solid #fecd07;border-radius:10px;bottom:0;box-shadow:none!important;color:#111;height:500px;left:0!important;margin:auto;max-width:400px;overflow:auto;padding:0;right:0;top:0!important;width:100%;z-index:2147483647!important}.loading:before,.loading:not(:required):after{content:'';display:block}.loading,.loading:before{position:fixed;top:0;left:0}.loading{z-index:999;height:2em;width:2em;overflow:show;margin:auto;bottom:0;right:0}.loading:before{width:100%;height:100%;background-color:rgba(0,0,0,.3)}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0;box-shadow:rgba(0,0,0,.75) 1.5em 0 0 0,rgba(0,0,0,.75) 1.1em 1.1em 0 0,rgba(0,0,0,.75) 0 1.5em 0 0,rgba(0,0,0,.75) -1.1em 1.1em 0 0,rgba(0,0,0,.75) -1.5em 0 0 0,rgba(0,0,0,.75) -1.1em -1.1em 0 0,rgba(0,0,0,.75) 0 -1.5em 0 0,rgba(0,0,0,.75) 1.1em -1.1em 0 0}@media only screen and (min-width:768px) and (max-width:1024px){.contestFrm.form_format1 li{float:left;width:100%!important}}@media only screen and (max-width:767px){article{width:100%!important}.contestFrm.form_format1 li{float:left;width:100%!important}#popupUpload{max-width:300px;padding:10px}.agreebuttons{margin-bottom:32px}}@media only screen and (max-width:540px){#popupUpload{max-width:300px;padding:10px;max-height:400px;overflow:auto;box-sizing:border-box;-webkit-box-sizing:border-box}.agreebuttons{margin-bottom:32px}#popupUpload h1{margin:5px 0}}

#popup3_album_515 #sharePostfriends{float:left;margin:20px 40%;text-align:center}#popup_adv{float:left;position:relative;width:100%}#inner_popup_adv{float:left;height:100%;position:absolute;width:100%;z-index:99}#popup3_album_515,.b-modal1-album-515{position:fixed;background:#000;left:0;top:0}#popup3_album_515{border:4px solid #ff0;bottom:0;box-sizing:border-box;-webkit-box-sizing:border-box;height:auto;margin:auto;max-height:500px!important;max-width:500px!important;overflow:auto;padding:10px!important;right:0;width:100%!important}#popup3_album_515 h1{padding:10px 0;text-transform:uppercase;margin-bottom:10px}#popup3_album_515 span#close{float:right;margin:10px;color:#fff;font-weight:700}#popup,#popup2,#popup3_album_515,.bMulti{background-color:#000;border-radius:10px;box-shadow:0 0 25px 5px #006099;color:#111;padding:25px;display:none}#popup3_album_515 span.b-close-album-515{border:none;float:right;color:#fecd07;cursor:pointer}.b-modal1-album-515{display:none;height:100%;z-index:99;opacity:.5;filter:alpha(opacity=50);zoom:1;width:100%}#popup2 #mycontent-album-515>p{color:#fff;font-size:15px;font-weight:700}#popup2 #mycontent-album-515>span{color:#fff}#popup3_album_515{z-index:99999;color:#FFF}#popup3_album_515 #mycontent-album-515>p{border-bottom:1px solid #fff;font-size:20px;margin-bottom:10px;padding-bottom:10px}#mycontent-album-515 li{background:#000;float:left;margin:10px 1%;max-height:150px;overflow:hidden;position:relative;width:31.3%}#mycontent-album-515 li img{max-width:100%;position:absolute;left:0;right:0;top:0;bottom:0;margin:auto}#mycontent-album-515>ul{float:left;width:100%}@media only screen and (min-width:540px){#mycontent-album-515 li{width:48% }}
	.sidebar-ads {
    margin-left: -64px;
}

</style>
<div class="planTap" style="margin-top: 20px;">Plan a Vacation. Plan a Night Out. <br>
					Plan Smarter!</div>
  <div id="loader"></div>
<div class="container bk_c">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 ct_t">
	    <h1>Memphis TN Attractions</h1>
		<a href=""><em>See All</em></a>
	</div>
	
  </div>
</div>

<div class="container custom-city-slider">

   <?php

	$getAds1 = mysql_query("SELECT * FROM `affiliate_top_ads` WHERE `page_name` = 'city' ORDER BY `id` DESC LIMIT 1");
	$res1 = mysql_fetch_assoc($getAds1);
	?>	
					
     <div class = "sidebar-ads" style="width: 100%; padding: 4px;">
	    <span><?php echo $res1['af_code'];?></span>
	 </div>
	 
  
</div>

<div class="clear"></div>
<div class="v2_container">
<div class="headingActivity">

</div>
  <div class="v2_inner_main test12"> 
	<!--  SIDEBAR CODE -->
	<aside class="sidebar v2_sidebar">

		<div class="city_amazon">
		<h2 class="near_events_first"><?php echo $dropdown_city; ?> City Talk</h2>
		</div>
		<div class="alignleft">
		<?php 
			$getAds = mysql_query("SELECT * FROM `affiliate_banner` WHERE `page_name` = 'citytalk' ORDER BY `id` DESC LIMIT 0,8 ");
			while ($res = mysql_fetch_assoc($getAds))
			{
			
				echo $res['af_code'];
			?>

			<br><br>
		<?php 	}  ?>
		</div>
	</aside>
	<!--  SIDEBAR CODE END -->
	<article class="forum_content v2_contentbar newArticle" style="background: none; width: 46% !important;">
	 
		  <div class="v2_inner_main_content">
			<?php 
								if($_SESSION['popup_add_post'] == "added")
								{
									echo "<div id='successmessage' style='display: block;'>Post Added Successfully</div>";
									unset($_SESSION['popup_add_post']);
								}
								elseif($_SESSION['popup_add_post'] == "updated")
								{
									 echo "<div id='successmessage' style='display: block;'>Post Updated Successfully</div>";  
									 unset($_SESSION['popup_add_post']);
								}
								elseif($_SESSION['popup_add_post'] == "DELETED")
								{
									 echo "<div id='successmessage' style='display: block;'>Post Deleted Successfully</div>";  
									 unset($_SESSION['popup_add_post']);
								}


								?>
			
			<?php if(isset($_SESSION['user_id']))
			{
									?>
			<div id="ad_profile_pst">
			  <form id="CityTalkForm" class="popupform" name="forum" action="" method="post" onSubmit="return validate_forum();" enctype="multipart/form-data">
				<div class="ppost_newdesign">
				  <div class="lbl whbtn">
					<label >What&#39;s happening ?</label>
					<div id="u_0_s" class="_6a _m"> <a style="color:#FFF;" <?php if(!isset($_SESSION['user_id'])){?>href="<?php echo $SiteURL;?>city_talk.php" onclick="openLoginpop($(this).prop('href')); return false;"<?php }else{ ?> onclick="ShowUploadPop();" <?php } ?> id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb"> <span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf"> <img src="<?php echo $CloudURL; ?>images/upload_camera.png"> </i>Add Photo/Video<i class="_2wr"></i> </span>
					  <div class="_3jk">
						<input type="hidden" name="thumbnailPhoto" value="" id="thumbnailPhoto"  />
						<input type="hidden" name="FullPhoto" value="" id="FullPhoto"  />
						<input type="hidden" name="postVideo" value="" id="postVideo"  />
						<input type="hidden" name="postVideoURL" value="" id="postVideoURL"  />
						
						<span style="display: none;" id="file_upload_successs"><img src="<?php echo $CloudURL; ?>images/tick_green_small.png"></span> </div>
					  </a> </div>
					<textarea <?php if(!isset($_SESSION['user_id'])){?> onclick="openLoginpop('<?php echo $SiteURL;?>city_talk.php'); $('#add_post_text').text(''); return false;"<?php } ?> id="add_post_text"  name="forum" class="txt_box clear_flds"></textarea>
				  </div>
				  <div class="clear"></div>
				
				  <div class="whbtn">
					<div id="" class="pst_buttons">
					  <input id="submit3" type="submit" name="submit" value="Post" class="button add_pub_p_post" style=""  />
					</div>
				  </div>
				</div>
				<ul id="groups" style="display:none;">
				  <li>
					<textarea placeholder="Send To groups" cols="50" rows="5" name="search_val" id="search_val"></textarea>
					<input type="hidden" name="group" id="txt2">
					<p>Please type first few letters</p>
				  </li>
				</ul>
				<ul id="friends" style="display:none;">
				  <li></li>
				  <li>
					<textarea placeholder="Send To Friends" cols="50" rows="5" id="search_val2" name="search_val2"></textarea>
					<input type="hidden" name="friend" id="txt_f">
					<p>Please type first few letters</p>
				  </li>
				</ul>
			  </form>
			</div>
			<?php } ?>
			<?php
						$sql = "SELECT * FROM forum WHERE `post_from` IN ( 'city_talk' ) AND city_id='".$_SESSION['id']."' AND forum.status ='1' AND forum.from_user = forum.user_id ORDER BY `forum_id` DESC";
						
						
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
							if($row['user_type'] == "club")
							{
								
								$selecthostquery = @mysql_query('SELECT * FROM `clubs` WHERE id = "'.$row['user_id'].'" ');
								$reshostquery = @mysql_fetch_array($selecthostquery);
								$postername = $reshostquery['club_name'];
								$imagesrc = $reshostquery['image_nm'];
								$club_id = $reshostquery['id'];
								if(!isset($_SESSION['user_id']))
								{
									$anch = $postername;
								}
								elseif($_SESSION['user_id'] == $club_id)
								{
									
									$anch = "home_club.php";
									
								}
								else
								{
										
									$anch = "host_profile.php?host_id=".$club_id;
								}
								if($_SESSION['user_type'] == "user")
								{

									$host_details=@mysql_query("select status from  friends where friend_id='".$club_id."' AND user_id='".$_SESSION['user_id']."' AND friend_type='club'");
									$club_dtl=@mysql_fetch_assoc($host_details);                

								}
							}
							else
							{
								
								$selecthostquery = @mysql_query('SELECT * FROM `user` WHERE id = "'.$row['user_id'].'" ');
								$reshostquery = @mysql_fetch_array($selecthostquery);
								
								if(!empty($reshostquery['profilename'])){
									
									 $postername = $reshostquery['profilename'];
									
									}else{
									
									 $postername = $reshostquery['first_name']." ".$reshostquery['last_name'];
									
								}
								
								if($reshostquery['image_nm'] == "")
								{
									$imagesrc = "images/man1.jpg";
								}
								else
								{ 
									$imagesrc = $reshostquery['image_nm'];
								
								}
								
								if($_SESSION['user_id'] == $row['user_id']){
									
									$anch = "profile.php";
									
									}else{
										
									$anch = "profile.php?id=".$row['user_id'];
								}
							}

						   ?>
			<div class="post blog1 v2_post_citytalk">
			  <div class="v2_blogpost_user_new">
				<div class="deletPost">
				  <div class="manage_current_p_post manage">
					<?php
						if(isset($_GET['id']))
						{
						}
						else{
							if($row['from_user'] == $_SESSION['user_id'])
							{
						?>
					<a class="edit_post_pro" title="Edit" onclick="edit_post('<?php echo $row[forum_id]?>');" href="javascript:void(0);"><img src="<?php echo $SiteURL; ?>images/edti_post1.png"></a> <a class="del_post_pro" onClick="delete_post('<?php echo $row[forum_id]?>');" title="Delete" ><img src="<?php echo $SiteURL; ?>images/del_post.png"></a>
					<?php }}	?>
				  </div>
				</div>
				<div class="thumb_user_profile">
				  <?php if(isset($_SESSION['user_type'])){ ?>
				  <a href="<?php echo $anch; ?>" class="pic" style="width: 100%;">
				  <?php }else{
												
														if($row['user_type'] == "club"){ ?>
				  <a href="<?php echo $SiteURL.$postername; ?>" class="pic">
				  <?php }else{ ?>
				  <a href="<?php echo $anch; ?>" class="pic">
				  <?php }
													}
	 
															 if($row['user_id'] == '0')
															 {
																	$style = " ";
															 }
															 else
															 {
															 echo '<img src="'.$SiteURL.$imagesrc.'" />';
												echo "</a>";
												
										echo "</div>"; ?>
				  <div class="profileUserName">
					<?php if($row['user_type'] == "club"){ ?>
					<a href="<?php echo $SiteURL.$anch; ?>" class="pic"><?php echo $postername; ?></a>
					<?php }else{ ?>
					<a href="<?php echo $anch; ?>" class="pic">
					<?php	echo $postername; ?>
					</a>
					<?php }
																	$style= "";
																	?>
				  </div>
				  <?php  } ?>
				  <br />
				  <div class="dateposted"> <?php echo date('F j, Y l',strtotime($row['added_on'])); ?></div>
				  <div class="followdbtn">
					<?php if(isset($_SESSION['user_id']) && $_SESSION['user_type'] == "user" && $row['user_type'] == "club" ) {  //die('dfdfdfd');?>
					<a style="display: none;" id="block" href="javascript:void(0)" class="button follow_hostc block">Followed</a> 
					
					<?php if($club_dtl['status']=='active') { ?>
					<a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a> 
					
					<?php }else if($club_dtl['status']=='block') { ?>
					<a id="block" href="javascript:void(0)" class="button follow_hostc block_new">Followed</a> 
					
					<?php }else {  ?>
					<input type="submit" id="request" class="button follow_hostc" value="Follow Host" name="submit" onclick="savehost('<?php echo $club_id;?>','request')">
					<?php } }?>
				  </div>
				</div>
				<div class="sub_post blog_content_new">
				  <div id="forumcontent" class="post_container_left">
					<h1 id="cntrls" class="profileHead"> 
	
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
					  
					</h1>
					<div class="posted_image_box">
					  <?php $share_img='';
											
									if($row["forum_img"]!="") 
									{
							
										$fullImage = $SiteURL.str_replace("../", "", $row["forum_img"]);
										$thumbImage = $SiteURL.str_replace("../", "", $row["image_thumb"]);
										if($fullImage == "")
										{
											?>
					  <a href="#"> </a>
					  <?php 

										}
										else
										{
													
											if($row['post_from'] == "city_talk")
											{
													
												if (strpos($row['forum_img'],'upload') !== false) 
												{
								?>
					  <a href="<?php echo $fullImage; ?>" rel="group" class="fancybox"> 
					 
					  <img  <?php echo $style; ?> src="<?php echo $thumbImage; ?>" alt=""  /> 
					 
					  </a>
					  <?php 				
													$share_img=$fullImage; 
												}
												else
												{
									?>
					  <a href="<?php echo $SiteURL."upload/shout/images/".$row['forum_img']; ?>" rel="group" class="fancybox"> 
					
					  <img  <?php echo $style; ?> src="<?php echo $thumbImage; ?>" alt=""  /> 
					  
					  </a>
					  <?php 			
													$share_img=$SiteURL."upload/shout/images/".$row['forum_img']; 
												}

											}
											else
											{
								?>
					  <a href="<?php echo $fullImage; ?>" rel="group" class="fancybox"> 
					 
					  <img  <?php echo $style; ?> src="<?php echo $thumbImage; ?>" alt=""  /> 
					 
					  </a>
					  <?php 					
													$share_img=$fullImage; 
											}

										}   
										
									}
									else
									{
								?>
					  <?php 
										if($row["forum_video"]!="") 
										{
											$url = $row["forum_video"];
											if (strpos($url,'vimeo.com') !== false) {
												$share_img=$url;
											?>
					  <iframe src="<?php echo $url;?>" width="300" height="200" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					  <?php }else{ ?>
					  <a href="#dialogx" name="modal" class="videoPlayer" id="jw_<?php echo $row['forum_id'];?>">
					  <div  id="a<?php echo $row["forum_id"];?>"></div>
					  <script type="text/javascript">
																			jwplayer("a<?php echo $row["forum_id"];?>").setup({
																				file: "<?php echo $row['forum_video'];?>",
																				height : 140 ,
																				width: 200
																			});
																		</script> 
					  </a>
					  <?php 
																$share_img=$SiteURL.$row["forum_video"];
																}

															
														}
								?>
					  <?php 	} 	?>
					  <p class="discription">
						<?php 
											$des = strip_tags($row['description']);
											$des = str_replace('www.', ' www.', $des);
											echo $des;
								
								?>
					  </p>
					</div>
				  </div>
				  <div class="newCommentSys">
 
					
 
					<!--  <div class="like"> </div>-->
					<div class="commentSys">
					
						<?php
							$find = mysql_query("SELECT * FROM forum_comment where forum_id='".$row["forum_id"]."' ORDER BY id ASC");
							$count_comments = mysql_num_rows($find);

								$sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."'");
								$like_tot= @mysql_num_rows($sql_like);
		 
								$sql_usr_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."' AND like_user_id='".$_SESSION['user_id']."'");
								$is_like= @mysql_num_rows($sql_usr_like);
												?>
						<p id="report_error_<?php echo $row["forum_id"];?>" style="color:red; font-size:14px;"></p>
						<p id="report_send_<?php echo $row["forum_id"];?>" style="color:green font-size:14px;" ></p>
						<?php if($_SESSION['user_id']!="") {?>
						<span class="nolink" style="color: #000;" id="glike_<?php echo $row["forum_id"];?>">
						<?php if($is_like <= 0) { ?>
						<a href="javascript:void(0);"   onclick="flike('<?php echo $row["forum_id"];?>');">Shouts</a>
						<?php }else{ echo "Shouts"; }?>
						( <?php echo $like_tot; ?> )
						
						| </span> 
						
						
						<p id="show_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);">Comment ( <?php echo $count_comments; ?> )</p>
						<p id="hide_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);" style="display:none;">Comment ( <?php echo $count_comments; ?> )</p>
						
						<?php } ?>
      
      	<?php  if($row["user_id"]=='0'){ $shareurl=$share_img;}else{ $shareurl=$share_img;} ?>
       </div>
						<ul class="shareit">
       	<?php 
						  	if(isset($_SESSION['user_id']))
						  	{
						  	?>
						  	<li> 
						  		<a href='javascript:void(0);'> 
						  			<img src="<?php echo $SiteURL; ?>images/share_pst.png" alt="Share Post"/> 
					  			</a>
								<ul>
								  	<li> <a href="javascript:void(0);" onclick="sharepostPublic('<?php echo $row['forum_id'];?>');">Public</a> </li>
								  	<li> <a href="javascript:void(0);" onclick="sharepostPrivate('<?php echo $row['forum_id'];?>');">Friends List</a> </li>
								</ul>
						  	</li>
						  <?php }	?>
						  <li> <a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onclick="return fbs_click('<?php echo $shareurl;?>', 'Post From mysittidev.com' )" target="_blank" style="text-decoration:none;"><img src="<?php echo $SiteURL; ?>fbook.png" alt="Share on Facebook"/></a> </li>
						  <li> <a href="#" onclick="return fbs_click123('<?php echo $shareurl;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"><img src="<?php echo $SiteURL; ?>twt.png" alt="Share on Twitter"/></a> </li>
						  <li> <a href="https://plus.google.com/share?url=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?php echo $SiteURL; ?>g+.png" alt="Share on Google+"/></a> </li>
						 
						</ul>
					</div>
  
     <div class="comment_box commentdisplay">
					<div class="comments_load_more_section comments_load_more_section_main_<?php echo $row["forum_id"];?>">
					  <?php if(isset($_SESSION['user_id'])){  ?>
					  <button id="loadMore_<?php echo $row["forum_id"];?>" class="btn button">Show Previous Comments</button>
					  <?php } ?>
					  <img src="images/post-19702-0-58437300-1327865075.gif"> 
					</div>
					<div class="cmnts_container" id="comment_all_<?php echo $row["forum_id"];?>">
					  <input type="hidden" id="num_comments_<?php echo $row['forum_id'];?>" value="<?php echo $count_comments; ?>" />
					  <input type="hidden" id="common_identifier_<?php echo $row['forum_id'];?>" value="<?php echo $row['common_identifier']; ?>" />
					  <input type="hidden" id="set_show_val_<?php echo $row['forum_id']; ?>" value="0">
					  <div class="box3 show_all_comments" id="show_count_comments_<?php echo $row["forum_id"]; ?>">
						<div class="box4"> 
						  
						</div>
					  </div>
					  <?php
												$row_i = 0;
												while($row2 = @mysql_fetch_array($find)){

														$commentDatetime = date('F j, g:i a',strtotime($row2['added_date']));
													 ?>
					  <div class="jquery_unloaded_comments_<?php echo $row["forum_id"];?> box3 box3_hide_rep onload_comments hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>"> 
						
						<?php
						if($row2['user_type'] == 'club')
						{
							$getuser = @mysql_query("SELECT club_name, image_nm FROM `clubs` WHERE id='".$row2['user_id']."'");
						}
						else
						{
							$getuser = @mysql_query("SELECT first_name,last_name,profilename, image_nm FROM `user` WHERE id='".$row2['user_id']."'");
						}
						
						$getdet = @mysql_fetch_assoc($getuser); ?>
						<div class="commentator">
						  <?php if($row2['user_type'] == "user"){ ?>
						  <a href="profile.php?id=<?php echo $row2['user_id']; ?>">
						  <?php }elseif($row2['user_type'] == "club"){ ?>
						  <a href="host_profile.php?host_id=<?php echo $row2['user_id']; ?>">
						  <?php } ?>
						  <?php if($getdet['image_nm']=="") { ?>
						  <img src="<?php echo $SiteURL; ?>images/pic1.jpg" />
						  <?php }else{ ?>
						  <img width='40' height='40' src="<?php echo $SiteURL.$getdet['image_nm']; ?>"  />
						  <?php } ?>
						  <!-- </div> --> 
						  </a> </div>
						<div class="commentator_info">
						  <?php 
							if($row2['user_type'] == 'club')
							{
								?>
						  <a href="host_profile.php?host_id=<?php echo $row2['user_id']; ?>" class="commentuser"><?php echo $getdet['club_name']; ?></a><span class='commentDate'><?php echo $commentDatetime;?></span>
						  <div class="clear"></div>
						  <?php echo $emojione->shortnameToImage($row2['content']);?>
            </div>
						<?php 
							}
							else
							{
						?>
						<a href="profile.php?id=<?php echo $row2['user_id']; ?>" class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a><span class='commentDate'><?php echo $commentDatetime;?></span>
						<div class="clear"></div>
						<?php echo $row2['content']; 
						

						?></div>
					  <?php 
							}
						?>
					  <?php 
							if($_SESSION['user_id'] != '' && $row2['user_id'] == $_SESSION['user_id'] && $row2['user_type'] == $_SESSION['user_type'])
							{
						?>
					  <img class="delete_Comment" onclick="delete_comment('<?php echo $row2['id']; ?>', 'show_cm_<?php echo $row['forum_id']; ?>');" width="16px" height="16px" src="images/del-notification.png" style="float: right; cursor: pointer; border: medium none;">
					  <?php 
					
						}elseif($row['from_user'] == $_SESSION['user_id'] && $_SESSION['user_type'] == $_SESSION['user_type']){
											
						?>
					  <img class="delete_Comment" onclick="delete_comment('<?php echo $row2['id']; ?>', 'show_cm_<?php echo $row['forum_id']; ?>');" width="16px" height="16px" src="images/del-notification.png" style="float: right; cursor: pointer; border: medium none;">
					  <?php
						  
						}
						?>
					  
					
					</div>
					<?php $row_i++; } ?>
				  </div>
				  <?php 
											
					if($count_comments > 3){
						?>
				  <script type="text/javascript">
						$(document).ready(function () {
							
							$('#comment_all_<?php echo $row["forum_id"];?> .hide_replies_<?php echo $row["forum_id"];?>').last().addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
							
							$('#comment_all_<?php echo $row["forum_id"];?> .hide_replies_<?php echo $row["forum_id"];?>:nth-last-child(2)').addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
							
							$('#comment_all_<?php echo $row["forum_id"];?> .hide_replies_<?php echo $row["forum_id"];?>:nth-last-child(3)').addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
							
							$('#loadMore_<?php echo $row["forum_id"];?>').click(function () {
								
								var count_li = $('.jquery_unloaded_comments_<?php echo $row["forum_id"];?>').length;
								
								if (count_li >= 13) {
									
									$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').show();
									
									setInterval(function(){
										
											
									$(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>:gt("+($(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").length-11)+")").addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
											
									$('.comments_load_more_section > img').hide();
										
									}, 2000);
								
								}else{

									if ($(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").length == count_li) {
										
									$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').show();
									
									setInterval(function(){
										
										$(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>:gt("+($(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").length - count_li)+")").addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
										
										$(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").first().addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
											
										$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').hide();
											
										$('#loadMore_<?php echo $row["forum_id"];?>').hide();
										
									}, 2000);
									
									return false;
										
									}else{
										
										$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').show();
											
										setInterval(function(){
											
												
										$(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>:gt("+($(".jquery_unloaded_comments_<?php echo $row["forum_id"];?>").length - count_li)+")").addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
												
										$('.comments_load_more_section_main_<?php echo $row["forum_id"];?> > img').hide();
											
										}, 2000);
										
										return false;
										
									}
									
								}
							});
						});
					</script>
				  <?php }else{ ?>
				  <script type="text/javascript">
					$(document).ready(function () {
						$('#loadMore_<?php echo $row["forum_id"];?>').hide();
						$('#comment_all_<?php echo $row["forum_id"];?> .hide_replies_<?php echo $row["forum_id"];?>:lt(3)').addClass("jquery_loaded_comments_<?php echo $row["forum_id"];?>").removeClass("jquery_unloaded_comments_<?php echo $row["forum_id"];?>").show();
					});
				</script>
				  <?php } ?>
				  <div class="clear"></div>
				  <div class="box3 input_comment_area">
					<input type="hidden" id="fid_<?php echo $row["forum_id"];?>" value="<?php echo $row["forum_id"];?>">
     				<div class="commentwrap">
     					<div align='center'>
     					<?php
	                       if(!isset($_SESSION['user_id']))
	                        {  ?>
	                        <label for="login" id="v2_log_in" class="label_comment">Add Comment</label>
	                        <input type="checkbox" id="login" style="display: none;">
	                                              
	                       <?php } else { ?>
						  <input name="button" class="button btn_sub_comnt" id="co_submit_<?php echo $row["forum_id"];?>" type="button" onclick="renderComment('<?php echo $row["forum_id"];?>');" value="Add Comment" />
						  <img id="comment_load_<?php echo $row["forum_id"]; ?>" src="<?php echo $SiteURL; ?>images/loading-plz.gif" style="margin: -16px 0px 0px 0px; display: none;"> 
						  <?php  }  ?>
					  </div>
       						<div class="clear"></div>
					<div class="comment_txt">
					  <input name="comment" class="emojiUnique" id="content_<?php echo $row["forum_id"];?>" type="text" placeholder="Write a comment.." value="" style="color: #000;" data-emojiable="true"/>
		
					</div>
     				</div>
					
					<div id="comsuc_<?php echo $row["forum_id"];?>" style="float:right; color:green; display:none;"></div>
					<div class="pro_error" id="com_error_<?php echo $row["forum_id"]; ?>" style="float:right; color:red; display:none;"></div>
				  </div>
			<?php  ?>
				</div>
			  </div>
			</div>
			<?php 
						$iiii++; }
					}
					else
					{
						echo "<p id='errormessage' class='NoRecordsFound' style='display:block;'>Be the first to tell others about your amazing city.</p>";
					}
		?> 


<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "d1a0b5b3-5460-45ac-9d43-802d8c763b24", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

<script type="text/javascript">
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
						document.location.href = data;
						return false;
					}
				   });
			}

	}, 1000);	
}
</script>

<script type="text/javascript">
	$(document).ready( function() {
		
	$('#selectall').click(function() {
		   if ($('#selectall').is(':checked')) {
			   $('.others').attr('checked', true);
		   } else {
			   $('.others').attr('checked', false);
		   }
	   });
});

function goto(url)
{
	window.open(url,'1396358792239','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=200,top=200');
	return false;
}

</script>

<script>

$(document).ready(function() {
	
	$('#msg').fadeOut(1000);
});

function submitcom(event,id)
{
	if(event.keyCode == 13)  
	{
		$("#content_"+id).attr('disabled','disabled');  
		  addform(id);
	}
}

function flike(id)
{
	
	var url = 'f_id='+id+'&from=city_talk';
	$("#glike_"+id).html("Loading..");
	
	$.ajax({
		type: "POST",
		url: "flike.php",
		data: url,
		success: function(html){
			$("#glike_"+id).html("Shouts ( "+html+" ) |");
		
		}
	});
	
	return false;
}

	function delete_comment(id, comments_val) {
		
		var hide_all_split = comments_val.split("show_cm_");
		
		var hide_all = hide_all_split[1];
		
		var get_comments_val = $('#'+comments_val).html();
	
		var split1 = get_comments_val.split("Comment ( ");

		var split2 = split1[1].split(")");
		
		var count = split2[0];
		
		var comments_count = count.trim();
		
		var calculated_comments =  parseFloat(comments_count) - 1;

			var r = confirm("Are you sure want to delete the comment?");
			if (r == true) {
		
				jQuery.post('ajaxcall.php', {'delete_commment_id':id}, function(response){
					
					if(response == "deleted"){
						$('.c_box_'+id).remove();
						$('#'+comments_val).text('Comment ( '+calculated_comments+' )');
						
						if (calculated_comments == 0) {
							$('#showLess_'+hide_all).hide();
							$('#loadMore_'+hide_all).hide();
						}
					}
					
				});
			}
	}
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'mysittidev.com');
  ga('send', 'pageview');

</script>


<script type="text/javascript">
$(function(){
	$("#hitAjaxCity").click(function(){
	 var geodemo = $('#geo-demo').val();
        $.ajax({
                type: 'POST',
                url: 'ajax_city_talk.php',
                data: {formatted: geodemo},
                beforeSend: function()
			    {
			        $("#loader").addClass("loading");
			    },
                success: function(data) {
		            $('.city_amazon').html(data);
		            $('.near_events_first').hide();
		            $("#loader").removeClass("loading");
		        }
            });
        });
});	
</script>

<script type="text/javascript">
 $(document).ready(function(){
 $("#hitAjaxCity").click(function(){
  	var geodemo = $('#geo-demo').val();
     $.ajax({
	    url: "city_search_ajax.php",
	    type: "POST",
	    data: {
	      formatteds: geodemo
	    },
	    beforeSend: function()
	    {
	        $("#loader").addClass("loading");
	    },
	    success: function (response) 
	    {   
	 
		   	$("#loader").removeClass("loading");
		}
  	});                  
 }) 
});	
</script>

	
<script type="text/javascript">
	
	    $(function() {
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: 'emoji/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
       
        window.emojiPicker.discover();
        });
        function renderComment(id)
	    {
		   
		    var message = $("#content_"+id).val();

		    if (message.length > 0 && message != ""){

		    	$('#co_submit_'+id).hide();
				$('#comment_load_'+id).show();
				var set_val = $('#set_show_val_'+id).val();
				var common_identifier = $('#common_identifier_'+id).val();

          console.log(message, 'before');
          message = emojione.toShort(message);
          console.log(message, 'after');
		      $.ajax({
		        type : 'POST',
		        url : 'addComment.php',
		        data : {content : message, forun_id : id},
		        dataType: 'json',
		        success : function(response){
	              if(response.count >= 3)
	              {
	                
	              }
	              $('#show_cm_'+id).text('Comment ( '+response.count+' )');
	              $('#comment_all_'+id).append(response.message);
	              $('#comment_load_'+id).hide(); 
	              $('#co_submit_'+id).show();
	              $('#content_'+id).val(' ');

		        },
		        error : function(err){
		          console.log(err);
		        }
		      });
				} else {
					$('#comment_load_'+id).hide();
					$('#com_error_'+id).show();
					$('#com_error_'+id).html('Please enter comment. Do not use empty spaces.');
					$('#com_error_'+id).fadeOut(8000);
					$("#content_"+id).prop('disabled', false);
					return false;					
					
				}

		    }
	   
	$('.videoPlayer').each(function(){
		var i = $(this).attr('id');
		i = i.split('_');
		var id = i[1];


		$(this).hover(

			function () {
				var state = jwplayer('a'+id).getState();
				if(state != 'PLAYING')
				{
					jwplayer('a'+id).play();
				}
			}, 

			function () {
				var state = jwplayer('a'+id).getState();
				if(state == 'PLAYING')
				{
					jwplayer('a'+id).pause();
				}
				else if(state == 'BUFFERING')
				{
					jwplayer('a'+id).pause();
				}
				else if(state == 'IDLE')
				{
					jwplayer('a'+id).pause();
				}
			}
		);
	});
</script>

		<?php				
		echo '<div class="pagination">';
							if($pager->numPages > 1)
							{
								echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1"><span title="First">&laquo;</span></a>';
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									
									echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1)."'><span>Previous</span></a>";
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
									echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1)."'><span>Next</span></a>";
														
								echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages."'><span title='Last'>&raquo;</span></a>";
							}
						echo "</div>";




							if(isset($_SESSION['main_clubs_filter']) && isset($_SESSION['inner_clubs_filter'])){
							
								$club_filter=$_SESSION['main_clubs_filter'];
								$cnd=" parrent_id='0' AND  id IN(".$club_filter.")";
							
								$sql_main_club=@mysql_query("select * from club_category where ".$cnd." ORDER BY name ASC"); //case 2 :
							
							}else{
							
								$sql_main_club=@mysql_query("select * from club_category where parrent_id='0' ORDER BY name ASC"); //case 1 :
							
							}
							
							
							$get_single_club = @mysql_fetch_assoc($sql_main_club);
					?>
		  </div>
	
	  <?php 
	 
		$getFriends = mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$_SESSION['user_id']."' AND `user_type` = '$_SESSION[user_type]' AND fs.friend_id != 1 AND fs.friend_id != '$_SESSION[user_id]' AND fs.status IN ('active')
		GROUP BY friend_id ORDER BY id ASC");
?>
		<div style="display: none;" id="popup3_album_515">
			<span class="b-close-album-515">X</span>
			<div style="height: auto; width: auto;" id="mycontent-album-515">
				<h2 class="shareselect">Select Friends to share Post</h2>
				<div class="sel_all">
					<input type="checkbox" id="SelectALL" onclick="checkAllfriends();" name="selectAll"  /> Select All Friends
				</div>
    <div class="clear"></div>
				<ul class="SharingFriendslist">
    
				<?php 
				$i=0;
				while($fetchFriends=mysql_fetch_assoc($getFriends))
				{
					$i++;
					if($fetchFriends['friend_type'] == "user")
					{
						$friendQuery  = mysql_query("SELECT `profilename`,`id`,`is_online`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
											FROM `user` 
											WHERE `id` = '$fetchFriends[friend_id]'
										");
						$friendResult = mysql_fetch_assoc($friendQuery);
						if(!empty($friendResult['profilename'] ) )
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
											WHERE `id` = '$fetchFriends[friend_id]'
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
					if(!empty($friendName))
					{
				?>
					<li>
						<input type="checkbox" name="ShareFriends[]" value="<?php echo $friendID."-----".$fetchFriends['friend_type']; ?>" />&nbsp; <?php echo $friendName;?>
					</li>
			<?php 		}
				}
			?>
				</ul>
				<input type="button" id="sharePostfriends" onclick="sharePostFriends();" value="Share" />
				<input type="hidden" id="forumidtoshare" value="" />
			</div>
		</div>
	</article>
	<div class="adRightBar">

	    <a href="//c13.travelpayouts.com/click?shmarker=130544&promo_id=699&source_type=banner&type=click" target="_blank">
	  <img src="https://c13.travelpayouts.com/content?promo_id=699&shmarker=130544&type=init" alt="Car rentals EN -
					120*600" width="180" height="600">
		</a>
	</div>
  </div>
  <div id="popupUpload" style="">
	<div id="mycontent122" style="height: auto; width: auto;"> <span onclick="HideUploadPopEmpty();" class="closebutton" style="float:right; cursor:pointer;">X</span>
	  <h1 id="title">Choose Upload Media:</h1>
	  <div>
		<label>From Computer: </label>
		<input type="file" name="ComputerField" id="ComputerField" onChange="return ValidateFileUpload()" required>
	  </div>
	  <div class="Seperator">
		<label>OR</label>
	  </div>
	  <div>
		<label>File Url: </label>
		<input type="text" name="URLField" id="URLField" onclick="emptyComputerField();" />
		<br/>
		<p style="margin-bottom:0">Paste video link here Example:<br />
		  http://www.youtube.com/watch?v=a7SJF3ErXZU <br />
		  or<br />
		  https://player.vimeo.com/video/27578410 </p>
	  </div>
	  <input type="button" onclick="HideUploadPop();" class="button" value="Upload">
	</div>
  </div>
  <div class="b-modal" id="modalpopupUpload" style=""></div>
  <div class="clear"></div>
</div>

<script>
function checkAllfriends()
{
	if($('#SelectALL').is(':checked'))
	{
		$('.SharingFriendslist li input').each(function(){
			$(this).prop('checked', true);
		});	
	}
	else
	{
		$('.SharingFriendslist li input').each(function(){
			$(this).prop('checked', false);
		});	
	}	
}

function emptyComputerField()
{
	$('#ComputerField').val('')
}
function HideUploadPop()
{
	if($('#ComputerField').val() != "") 
	{
		if($('#URLField').val() == "")
		{

			var data = new FormData();
			$.each($('input[name^="ComputerField"]')[0].files, function(i, file) {
			data.append(i, file);
			});
			var SiteURL = $('#siteURL').val();
			$.blockUI({ css: {
					border: 'none',
					padding: '15px',
					backgroundColor: '#fecd07',
					'-webkit-border-radius': '10px',
					'-moz-border-radius': '10px',
					opacity: .8,
					color: '#000'
				},
				message: '<h1 class="uploading_media">Uploading Media</h1>'
			});
			$.ajax({
				url: SiteURL+'NewUploadFile.php',
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST',
				success: function(data){
					var result = data.split('+');
					if(result[0] == 'Video')
					{
						$('#postVideo').val(result[1]);
						$('#FullPhoto').val('');
						$('#postVideoURL').val('');
						$('#thumbnailPhoto').val('');
					}
					else
					{
						$('#postVideoURL').val('');
						$('#postVideo').val('');
						$('#FullPhoto').val(result[2]);
						$('#thumbnailPhoto').val(result[1]);

					}
					$.unblockUI({
						onUnblock: function(){
							if($('#CityTalkForm').hasClass('ajaxForm'))
							{
								$('.post_media').find('img').attr('src', result[1]);
							}
							$('#popupUpload').hide();
							$('#modalpopupUpload').hide();

						}
					});
				}
			});
		}
		else
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
				message: '<h1 class="uploading_media">Uploading Media</h1>'
			});
			$('#postVideoURL').val($('#URLField').val());
			$.unblockUI({
				onUnblock: function(){
					$('#popupUpload').hide();
					$('#modalpopupUpload').hide();
				}
			});
		}
	} else {
		alert("Choose upload any media.");
	}
}
function ShowUploadPop()
{
	$('#popupUpload').show();
	$('#modalpopupUpload').show();
}

function HideUploadPopEmpty()
{
	$('#popupUpload').hide();
	$('#modalpopupUpload').hide();
}
function addshout()
{
	if($('#shout').val()=="")
	{
		$('#error_shout').html('Please enter your shout');
		$('#error_shout').fadeOut(5000);
		return false;
	}	
	else
	{
		$('#shout_frm').submit();
	}
}
function Edit_shout()
{
	if($('#shout_edit').val()=="")
	{
		$('#error_shout').html('Please enter your shout');
		$('#error_shout').fadeOut(5000);
		return false;
	}
	else
	{  
		$('#shout_frm_edit').submit();
	}
}
function editshout(id)
{
	$.get("getshotdetails.php?id="+id, function( data ) {
		$('#shout_edit').val(data);
		$("#shout_ac_edit" ).click();
		$("#edit_id" ).val(id);
	});	
}


</script>

<script type="text/javascript">
function fetchclubs(id)
{
	var catid1 = id.split('_');
	var cityid = "<?php echo $_SESSION['id']; ?>";
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
			$('#list_'+catid1[1]).html(data);
		}
	});
}

function ValidateFileUpload(){
		var check_image_ext = $('#ComputerField').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg','mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
			alert('Post Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
			$('#ComputerField').val('');
		}else{
			$('#file_upload_successs').show();
		}
		$('#URLField').val('');
}

function validate_forum()
{
	
   var value = $('#add_post_text').val();
   if( $('#add_post_text').val() == "" || $('#add_post_text').val() == " " || value < 1)
   {
		alert( "Please provide city talk title!" );
		document.forum.forum.focus();
		return false;
	}
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

function edit_post(id){
	
	jQuery("html, body").animate({ scrollTop: jQuery("#title").offset().top }, "slow");
	
	jQuery.post('edit_profile_post.php', {'forum_id': id}, function(response){
		
		jQuery("#ad_new_pst").show();
		jQuery("#ad_profile_pst").empty();
		jQuery("#ad_profile_pst").html(response);
		
	});
}

function delete_post(id){
	
	var r = confirm("Are you sure want to delete?");
	if (r == true) {

	 $.get( "deletepost.php?action=delcitytalk&id="+id, function( data ) {
			window.location = "";
		});
	
	}
}

$(document).ready(function(){
	$('.b-close-album-515').click(function(){
		$('#popup3_album_515').hide();
	});
});

function sharepostPublic(forumid)
{
	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'forumid' : forumid,
			'action' : 'sharePostPublic',
		},
		success: function(data){
			alert('Post shared Publically!');
			return false;
		}
	});
}

function sharepostPrivate (forumid) 
{
	$('#popup3_album_515,#fullOverlay').show();
	$('#forumidtoshare').val(forumid);
}


function sharePostFriends()
{
	var forumid = $('#forumidtoshare').val();

	var stringids = $.map($(':checkbox[name=ShareFriends\\[\\]]:checked'), function (n, i) {
					return n.value;
			}).join(',');

	$.ajax({
		type: "POST",
		url: "refreshajax.php",
		data: {
			'string' : stringids,
			'forumid' : forumid,
			'action' : 'sharePostFriends',
		},
		success: function(data){
			
			alert('Post shared with selected Friends!');
			$('#popup3_album_515').hide();
			$('#fullOverlay').hide();
			return false;
		}
	});
}

</script>
<?php 
	include('LandingPageFooter.php');
 ?>
