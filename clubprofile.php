<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
include 'googleplus-config.php';
// if(!isset($userID)){
// 	$Obj->Redirect("login.php");
// 	die;
// }

/*******************************  FACEBOOK SHARE CODE  ***********************************/

require_once 'facebook-php-sdk-v4-4.0-dev/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;

// FacebookSession::setDefaultApplication( FBAPPID,FBAPPSECRET );
FacebookSession::setDefaultApplication( '1660200180914018','a0dc6a39b581b2c74ea870bcb46f0a81' );

/*******************************  FACEBOOK SHARE CODE  ***********************************/

/* to check  user is friend with requested id */

if(isset($_GET['host_id']) && isset($_SESSION['user_id'])){	
	$query_string = "SELECT count(id) as frnd FROM friends where user_id='".$_SESSION['user_id']."' AND friend_id='".$_GET['host_id']."'";
	$result = @mysql_query($query_string);
	$result=@mysql_fetch_array($result);
	$both_are_friend=$result['frnd'];

}

/* */

$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
if($para!="");
{
	if($para=="success")
	{
		$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
		$message="Invalid Image.";
	}
}
$titleofpage=" Blog";
if(!isset($_SESSION['user_id']))
{
	include('PublicProfileHeader.php');
}
else
{
	if(isset($_GET['host_id']))
	{
		include('NewHeadeHost.php');
	}
	else
	{
		include('NewHeadeHost.php');	
	}
}

require_once("admin/paging.php");
?>

<style>
.show_all_comments .box3{
	color: rgb(254, 205, 7);
	
	text-decoration: underline;
}

.onload_comments{
	display: none;
}

.hide_cm{
	display: none;
}
</style>

<script src="<?php echo $SiteURL;?>js/private-zone.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $SiteURL;?>css/style_popup.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">


<script>
	function delete_comment(id, comments_val) {
		
		var hide_all_split = comments_val.split("show_cm_");
		
		var hide_all = hide_all_split[1];
		
		var get_comments_val = $('#'+comments_val).html();
	
		var split1 = get_comments_val.split("Comment ( ");

		var split2 = split1[1].split(")");
		
		var count = split2[0];
		
		var comments_count = count.trim();
		
		var calculated_comments =  parseFloat(comments_count) - 1;

			var r = confirm("Are you sure want to delete the comment !");
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
	
	function clear_fields(){
		
		$('.clear_flds').val('');
	}
	
</script>

<?php

// ini_set("display_errors", "1");
// error_reporting(E_ALL);



if($_POST['update'])
{
	
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
		$user_id = $_SESSION['user_id'];
		//$added_on = date("Y-m-d h:i:s");
		$status = 1;
		//$forum_city=
		$ThisPageTable='forum';
		$forum = mysql_real_escape_string($_POST['forum']);
		$added_on = date("Y-m-d");

		mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."', forum_img = '".$file."', image_thumb = '".$forum_img."', forum_video = '".$forum_video."' WHERE user_id != '0' AND forum_id = '".$_POST['forum_id']."'");
		
		$_SESSION['post_edit_success'] = "updated";
		
	}
	else
	{
		
		$forum = mysql_real_escape_string($_POST['forum']);
		$added_on=date("Y-m-d");
		
		mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."' WHERE user_id != '0' AND forum_id = '".$_POST['forum_id']."'");
		
		$_SESSION['post_edit_success'] = "updated";
		
	}

		/*******************************  FACEBOOK SHARE CODE  ***********************************/
		
		if(isset($_SESSION['fb_token']))
		{

			if(!empty($_POST['thumbnailPhoto'])){
				
				$forum_img = $SiteURL.$_POST['thumbnailPhoto'];
			}
			else
			{
				$forum_img = $SiteURL."images/logo.jpg";
			}
			
			$session = new FacebookSession( $_SESSION['fb_token'] );

			// graph api request for user data
			$request = 	new FacebookRequest( $session, 'POST', '/me/feed', array(
						'name' => $forum,
						'caption' => 'mysitti.com',
						'link' => 'https://mysitti.com',
						'message' => 'New Blog Post',
						'picture' => $forum_img
					) );

			$response = $request->execute();

		}
				
		/*******************************  FACEBOOK SHARE CODE  ***********************************/
		
		/** TWITTER POST SHARE **/
		
		if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
		{
			include_once("twitter/config.php");
			include_once("twitter/inc/twitteroauth.php");
			
			//Success, redirected back from process.php with varified status.
			//retrive variables
			$screenname 		= $_SESSION['request_vars']['screen_name'];
			$twitterid 			= $_SESSION['request_vars']['user_id'];
			$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
			$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
		
			//Show welcome message
			echo '<div class="welcome_txt">Welcome <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>!</div>';
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
			
			//see if user wants to tweet using form.
			if(isset($forum)) 
			{
				//Post text to twitter
				$my_update = $connection->post('statuses/update', array('status' => $forum));
				//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php
			}
		}
				
		/**TWITTER POST SHARE**/	
	
	//die;
}




if($_POST['submitPOST'])
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

	if(isset($_GET['host_id']))
	{
		$user_id=$_GET['host_id'];
	}
	else
	{
		$user_id=$_SESSION['user_id'];	
	}
	
	
	$added_on=date("Y-m-d h:i:s");
	$status=1;
	//$forum_city=
	$ThisPageTable='forum';

	$city = $_SESSION['id'];


	$ValueArray = array($_SESSION['user_type'],date('YmdHis'),$_SESSION['user_id'],'blog','club',$forum_img,$forum,$file,$forum_video,$user_id,$added_on,$city,$_POST['post_type'],$status,"","");
	$FieldArray = array('postfrom_usertype','common_identifier','from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id');



// echo "<pre>"; print_r($FieldArray); print_r($ValueArray); exit;

	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	
		/*******************************  FACEBOOK SHARE CODE  ***********************************/
		
		if(isset($_SESSION['fb_token']))
		{
			
			if(!empty($forum_img)){
				
				$forum_img = $SiteURL.$forum_img;
			}
			else
			{
				$forum_img = $SiteURL."images/logo.jpg";
			}
			
			$session = new FacebookSession( $_SESSION['fb_token'] );
			
			// graph api request for user data
			$request = 	new FacebookRequest( $session, 'POST', '/me/feed', array(
						'name' => $forum,
						'caption' => 'mysitti.com',
						'link' => 'https://mysitti.com',
						'message' => 'New Blog Post',
						'picture' => $forum_img
					) );
			$response = $request->execute();
		}
				
		/*******************************  FACEBOOK SHARE CODE  ***********************************/
		
		/** TWITTER POST SHARE **/
		
		if(isset($_SESSION['status']) && $_SESSION['status']=='verified') 
		{
			include_once("twitter/config.php");
			include_once("twitter/inc/twitteroauth.php");
			
			//Success, redirected back from process.php with varified status.
			//retrive variables
			$screenname 		= $_SESSION['request_vars']['screen_name'];
			$twitterid 			= $_SESSION['request_vars']['user_id'];
			$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
			$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
		
			//Show welcome message
			echo '<div class="welcome_txt">Welcome <strong>'.$screenname.'</strong> (Twitter ID : '.$twitterid.'). <a href="index.php?reset=1">Logout</a>!</div>';
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
			
			//see if user wants to tweet using form.
			if(isset($forum)) 
			{
				//Post text to twitter
				$my_update = $connection->post('statuses/update', array('status' => $forum));
				//die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php
			}
		}
				
		/**TWITTER POST SHARE**/	   
	
	if($Success > 0)
	{
		if($_POST['action']=="/upload_video.php")
		{
		  	header('location: upload_video.php');exit;
		}
		elseif ($_POST['action'] == "/upload_photo.php") {
		  	# code...
		  	header('location: upload_photo.php');exit;
		}
		else
		{
			if($_POST['post_type']=='private')
			{
				$_SESSION['popup_add_post'] = "added"; 
			}
			else
			{
				$_SESSION['success']="Post updated successfully";
		  	}		  
		}
	}
	  
	$_SESSION['popup_add_post'] = "added"; 
}

if(isset($_REQUEST['host_id']))
{
	$userID=$_REQUEST['host_id'];
}
else
{
	$userID=$_SESSION['user_id'];	
}
	$sql = "select * from `clubs` where `id` = '".$userID."'";
	$userArray = $Obj->select($sql) ; 
	$hostID = $userID;
	$club_name=$userArray[0]['club_name'];
	$plantype = $userArray[0]['plantype'];
	$typeclub = $userArray[0]['type_of_club'];
	$email=$userArray[0]['club_email'];
	$club_address=$userArray[0]['club_address'];
	$phone=$userArray[0]['club_contact_no']; 
	$country=$userArray[0]['club_country'];
	$state=$userArray[0]['club_state'];
	$club_city=$userArray[0]['club_city'];
	$web_url=$userArray[0]['web_url'];
	$zipcode=$userArray[0]['zip_code'];
	$google_map_url=$userArray[0]['google_map_url'];	
	$image_nm  =$userArray[0]['image_nm'];
//	$_SESSION['username']=$club_name;
	//echo "select g.group_name,g.id from  chat_users_groups as cgs  join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$userID."' group by g.id";die;
	$get_groups=mysql_query("select g.group_name,g.id from  chat_users_groups as cgs 
	  join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$userID."' group by g.id");
	$get_friends=mysql_query("select u.first_name,u.last_name,u.id from   friends as f 
   join user as u on(u.id=f.friend_id) where f.user_id 	='".$userID."' group by f.friend_id");
	/**********************************/
?>

<style>
a.commentuser{
	text-decoration: none;
	}
</style>

<!--<script src="js/jqueryvalidationforsignup.js" type="text/javascript"></script>
<script src="js/register.js" type="text/javascript"></script>--> 
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php
		if(isset($_GET['host_id']))
		{
			//die('dfdfdfdffdfd');
			include('host_left_panel.php');  
		}
		else
		{
			include('club-right-panel.php');
		}
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar newArticle">
			 
					<div class="v2_inner_main_content clubprofile_container">
  						<div class="shoutImg">
							<a onclick="javascript:window.open('shout.php','_blank','toolbar=no, scrollbars=yes, resizable=yes, top=400, left=400, width=750, height=600');" href="javascript:void(0);"><span>Give your fans a shout out!</span><img src="images/shout.png"></a>
						</div>
  						<h3 id="title" style="width: 70%;">Fan Page</h3>
  						<?php
  						$sql4 = "select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from mysittid_latest.friends as fs where fs.user_id='".$_SESSION['user_id']."' AND fs.friend_id != 1 AND fs.friend_id != '".$_SESSION['user_id']."' AND fs.status IN ('active') GROUP BY friend_id ORDER BY id ASC;";
  						$sql67=@mysql_query($sql4);
  						$num=@mysql_num_rows($sql67);
  						?>
  						<a href="all_connections.php"><h3 class="fansTitle"><?php echo $num; ?> Fans</h3></a>
						 <? 
						 	if(isset($_GET['msg']))
					 		{
					 			echo '<div id="successmessage" style="margin-bottom:6px;"> Successfully uploaded</div> ' ;
							}

							if(isset($_SESSION['popup_add_post']))
							{
								if($_SESSION['popup_add_post'] == "DELETED")
								{							
									echo '<div id="successmessage" style="margin-bottom:6px;"> Post Successfully Deleted</div> ';
									unset($_SESSION['popup_add_post']); 
								}
								else
								{								
									echo '<div id="successmessage" style="margin-bottom:6px;"> Post Successfully Added</div> ';
								}
								unset($_SESSION['popup_add_post']); 
							}
						?>
						<div id="ad_profile_pst">
						<?php 
							if(isset($_SESSION['user_id']))
							{
						?>
							<form id="post_cm_form" class="popupform" name="forum" action="" method="post" enctype="multipart/form-data">
								<div class="ppost_newdesign">
									<div class="lbl whbtn">  
										<label>What&#39;s happening ?</label>
										<div id="u_0_s" class="_6a _m">
											<a id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb" onclick="ShowUploadPop();"> 
												<span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf">
													<img src="<?php echo $SiteURL; ?>images/upload_camera.png">
													</i>Add Photo/Video<i class="_2wr"></i>
												</span>
											
												<div class="_3jk">
													<input type="hidden" name="thumbnailPhoto" value="" id="thumbnailPhoto"  />
													<input type="hidden" name="FullPhoto" value="" id="FullPhoto"  />
													<input type="hidden" name="postVideo" value="" id="postVideo"  />
													<input type="hidden" name="postVideoURL" value="" id="postVideoURL"  />
													<!-- <input type="file" aria-label="Upload Photos/Video" name="forum_img" title="Choose a file to upload" class="_n _5f0v" id="js_0" onChange="return ValidateFileUpload()"> -->
													<span style="display: none;" id="file_upload_successs"><img src="<?php echo $SiteURL; ?>images/tick_green_small.png"></span>
												</div>
											</a>
										</div>
										<textarea id="add_post_text" name="forum" class="txt_box clear_flds ad_c_post" /></textarea>
									</div>
									<div class="clear"></div>
								   <div class="whbtn">
										<input type="hidden" name="post_type" value="public" />
										<input id="submit3" type="submit" name="submitPOST" value="Post" class="button" style=""  />

								   </div>
								   
								</div>
						   	</form>
						  <?php 	}	?>		
						</div>
						<div id="middle" style="min-height:329px;" class="profile_page">  
				<?php 
					$sql12 = "SELECT * FROM `forum` as f, `clubs` as u WHERE f.user_id = '$userID'  AND f.user_id = u.id AND f.forum_type IN ('public','regular') AND f.status = '1' AND f.post_from = 'blog' ORDER BY `forum_id` DESC";
					$sql1 = @mysql_query($sql12);
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
					$sql12 = $sql12 . " limit $offset, $limit";

					if(isset($_GET['host_id']) && $both_are_friend==0)
					{
						echo "<p style='color:white;font-size:17px;'>No post to show as you are not friend with ".$club_name."</p>";
					}
					else
					{
						if($count > 0)
						{
							$sql12 = @mysql_query($sql12);
							$iiii = 1;	
							while($row = @mysql_fetch_assoc($sql12))
							{
								if($row['from_user'] != '0')
								{
									if($row['postfrom_usertype'] == 'club')
									{
										$getusersql = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$row['from_user']."'");
										$fetchusersql = mysql_fetch_array($getusersql);
										$row['image_nm'] = $fetchusersql['image_nm'];
										$fullname = $fetchusersql['club_name'];
										$pageLink = 'host_profile.php?host_id='.$fetchusersql['id'];
									}
									elseif($row['postfrom_usertype'] == 'user')
									{
										$getusersql = mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."'");
										$fetchusersql = mysql_fetch_array($getusersql);
										
										$row['image_nm'] = $fetchusersql['image_nm'];
										if(empty($fetchusersql['profilename']))
										{
											$fullname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];
										}
										else
										{
											$fullname = $fetchusersql['profilename'];
										}
										$pageLink = 'profile.php?id='.$fetchusersql['id'];
									}
									else
									{
										if(($_SESSION['user_type'] == "user") && ($row['user_type'] == "user") )
										{
											
											$getusersql = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."'");
											$fetchusersql = @mysql_fetch_array($getusersql);
											
											$row['image_nm'] = $fetchusersql['image_nm'];
											$fullname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];	
											$pageLink = 'profile.php?id='.$fetchusersql['id'];
										
										}
										elseif(($_SESSION['user_type'] == "user") && ($row['user_type'] == "club"))
										{
											$row['image_nm'] = $row['image_nm'];
											$fullname = $row['club_name'];
											$pageLink = 'host_profile.php?host_id='.$row['user_id'];
											
										}
										elseif(($_SESSION['user_type'] == "club") && ($row['user_type'] == "user"))
										{
											$getusersql = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['from_user']."'");
											$fetchusersql = @mysql_fetch_array($getusersql);
											
											$row['image_nm'] = $fetchusersql['image_nm'];
											$fullname = $fetchusersql['first_name']." ".$fetchusersql['last_name'];	
											$pageLink = 'profile.php?id='.$fetchusersql['id'];
										}
										else
										{
											$row['image_nm'] = $row['image_nm'];
											$fullname = $row['club_name'];
											$pageLink = 'host_profile.php?host_id='.$row['id'];
										}
									}
								}
								else
								{
									$row['image_nm'] = $row['image_nm'];
									$fullname = $row['club_name'];
									$pageLink = 'host_profile.php?host_id='.$row['id'];
								}
							 ?>
								<div class="post blog1  v2_post_citytalk"> 
								
									<div class="v2_blogpost_user_new">
											<div class="deletPost">
												<?php
													// if(isset($_GET['host_id']))
													// {

													// }
													// else
													// {
														if( ( $row['user_id'] == $_SESSION['user_id'] && $row['user_type'] == $_SESSION['user_type'] ) || ($row['from_user'] == $_SESSION['user_id'] && $row['postfrom_usertype'] == $_SESSION['user_type'] ))
														{ 
												?>
															<!-- edit controls -->
															<div class="manage_current_p_post manage">
																<a class="edit_post_pro" title="Edit" onClick="edit_blog_post('<?php echo $row["forum_id"]; ?>');" href="javascript:void(0);"><img src="images/edti_post1.png"></a>
																<a  class="del_post_pro"  title="Delete" onClick="delete_blog_post('<?php echo $row["forum_id"]; ?>');" href="javascript:void(0);"><img src="images/del_post.png"></a>
															</div>
															<!-- /edit controls -->    
												<?php 		}
													//} 
												?>												
											</div>
											
											<div class="thumb_user_profile">
											<a href="<?php echo $pageLink; ?>" class="pic">
														
														<?php
															if($row['image_nm'] == "")
															{
																echo '<img src="images/man4.jpg" />';
															}
															else
															{ 
																$imagesrc = $row['image_nm'];
																echo '<img src="'.$imagesrc.'" />';
															}
														?>
														</a>
											</div>
											
											<div class="profileUserName">
											<a href="<?php echo $pageLink; ?>" class="pic">
													<?php echo $fullname; ?>
												</a>											
											</div>
											<br />
											<div class="dateposted">
												<?php 
											 		if($row['added_on'] != '0000-00-00')
										 			{	
											 			echo date('F j, Y',strtotime($row['added_on'])); 
										 			}
										 			elseif($row['event_date'] != '0000-00-00 00:00:00')
										 			{
										 				echo date('F j, Y',strtotime($row['event_date'])); 	
										 			}
										 		?>
											</div>
									</div>
								
									<div class="sub_post blog_content_new">
										<div id="forumcontent" class="post_container_left">
											<h1 id="cntrls" class="profileHead"><?php echo $row['forum']; ?> </h1>
												<div class="posted_image_box">
													<?php 
														$share_img='';
														if($row["forum_img"]!="") 
														{
													?>
															<a href="<?php echo $row['forum_img']; ?>" rel="group" class="fancybox"><img src="<?php echo $row['image_thumb']; ?>" alt="" /></a>
													<?php 
															$share_img=$row["forum_img"]; 
														} 
														if($row["forum_video"]!="") 
														{
															$url = $row["forum_video"];
															if (strpos($url,'vimeo.com') !== false) { ?>

																	<iframe src="<?php echo $url;?>" width="300" height="200" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

															<?php }else{ ?>
															
																	<a class="videoPlayer" id="jw_<?php echo $row['forum_id'];?>" href="#dialogx" name="modal">
																		<div id="a<?php echo $row["forum_id"];?>"></div>
																		<script type="text/javascript">
																			jwplayer("a<?php echo $row["forum_id"];?>").setup({
																				file: "<?php echo $row['forum_video'];?>",
																				height : 140 ,
																				width: 200
																			});
																		</script>
																	</a>   				
															
															<?php }

															$share_img=$row["forum_video"];
														} 
													?>	
												</div>			
										</div>
										
										  <div class="newCommentSys">
            <div class="commentSys">
												<?php
						
													$find = mysql_query("SELECT * FROM forum_comment where forum_id='".$row["forum_id"]."' ORDER BY id ASC");
													$count_comments = mysql_num_rows($find);
													  	$sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."'");
														$like_tot= @mysql_num_rows($sql_like);
														$sql_usr_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."' AND like_user_id='".$_SESSION['user_id']."'");
														$is_like= @mysql_num_rows($sql_usr_like);
														
														if($_SESSION['user_id']!="") 
														{
													?>    
															<span id="glike_<?php echo $row["forum_id"];?>">
												  		<?php 
													  			if($is_like <= 0) 
												  				{ 
												  		?>
																	<a href="javascript:void(0);" onclick="newflike('<?php echo $row["forum_id"];?>');">Shouts</a>
														<?php 		}
																else
																{ 
																	echo "Shouts "; 
																} 
														?>
																( <?php echo $like_tot; ?> )	
																| 
															</span>
															<!-- <a href="javascript:void(0);" onClick="javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment</a> -->
<!--                        <a id="show_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);" onclick="show_all_comments('<?php echo $row['forum_id']; ?>'); javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment ( <?php echo $count_comments; ?> )</a>-->
<!--		<a id="hide_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);" style="display:none;" onclick="hide_all_comments('<?php echo $row['forum_id']; ?>'); javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment ( <?php echo $count_comments; ?> )</a>-->

		<p id="show_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);">Comment ( <?php echo $count_comments; ?> )</p>
		<p id="hide_cm_<?php echo $row['forum_id']; ?>" href="javascript:void(0);" style="display:none;">Comment ( <?php echo $count_comments; ?> )</p>
													<?php
															$rep_abs = mysql_query("SELECT user_id FROM forum WHERE forum_id = '".$row["forum_id"]."'");
															$get_u_id = mysql_fetch_assoc($rep_abs);

															if($get_u_id['user_id'] != $_SESSION['user_id'])
															{ 
													?>												
																<!-- | <a href="javascript:void(0);" onClick="reportabuse('<?php echo $row["forum_id"];?>');">Report Abuse</a> 								 -->
												<?php 			}  
														} 
													?>
										 
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
            <li>
													<a rel="nofollow" href="javascript:void(0);" class="fb_share_button" <? /* onclick="return fbs_click('https://www.mysitti.com/<?php echo $share_img;?>', 'mysitti.com' )" */ ?> target="_blank" style="text-decoration:none;"><img src="fbook.png" alt="Share on Facebook"/></a>	
             </li>
             <li>
             
													<a href="#" onclick="return fbs_click123('https://www.mysitti.com/<?php echo $share_img;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"><img src="twt.png" alt="Share on Twitter"/></a>			
             	 </li>
             <li>
													<a href="https://plus.google.com/share?url=https://www.mysitti.com/<?php echo $share_img;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="g+.png" alt="Share on Google+"/></a>
              </li>
             </ul>
								   		 
									 </div>
											<div class="comment_box commentdisplay">
											<div class="comments_load_more_section comments_load_more_section_main_<?php echo $row["forum_id"];?>">
												<button id="loadMore_<?php echo $row["forum_id"];?>" class="btn button">Show Previous Comments</button>
												<img src="images/post-19702-0-58437300-1327865075.gif">
											</div>											
											
											<div class="cmnts_container" id="comment_all_<?php echo $row["forum_id"];?>">
												
													<input type="hidden" id="num_comments_<?php echo $row['forum_id'];?>" value="<?php echo $count_comments; ?>" />
													<input type="hidden" id="set_show_val_<?php echo $row['forum_id']; ?>" value="0">
													<div class="box3 show_all_comments" id="show_count_comments_<?php echo $row["forum_id"]; ?>">
														<div class="box4">
															<!-- <div class="show_cmnt" onclick="show_all_comments('<?php echo $row['forum_id']; ?>');" id="show_cm_<?php echo $row['forum_id']; ?>">Show comments : <?php echo $count_comments; ?></div>
															<div class="hide_cm" onclick="hide_all_comments('<?php echo $row['forum_id']; ?>');" id="hide_cm_<?php echo $row['forum_id']; ?>">Hide all comments</div> -->
														</div>
													</div>						
												<?php
													$row_i = 0;
													while($row2 = @mysql_fetch_assoc($find))
													{

															$commentDatetime = date('F j, g:i a',strtotime($row2['added_date']));
													?>					
															<div class="jquery_unloaded_comments_<?php echo $row["forum_id"];?> box3 box3_hide_rep onload_comments hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>">
													<?php
																if($row2['user_type'] == 'club')
																{
																	$getuser = @mysql_query("SELECT club_name, image_nm FROM `clubs` WHERE id='".$row2['user_id']."'");
																	
																	$url_set = "host_profile.php?host_id=".$row2['user_id'];
																}
																else
																{
																	$getuser = @mysql_query("SELECT first_name,last_name,profilename, image_nm FROM `user` WHERE id='".$row2['user_id']."'");
																}
																
																$getdet = @mysql_fetch_assoc($getuser);
																
																if($row2['user_type'] == "user"){
																	
																		if($getdet['image_nm']=="") 
																		{
																			echo "<div class='commentator'><a href='profile.php?id=".$row2['user_id']."'><img src='images/pic1.jpg' /></a></div>";
																		}
																		else
																		{
																			echo "<div class='commentator'><a href='profile.php?id=".$row2['user_id']."'><img width='40' height='40' src='".$getdet['image_nm']."'  /></a></div>";
																		}																	
																	
																}elseif($row2['user_type'] == "club"){
																	
																		if($getdet['image_nm']=="") 
																		{
																			echo "<div class='commentator'><a href='host_profile.php?host_id=".$row2['user_id']."'><img src='images/pic1.jpg' /></a></div>";
																		}
																		else
																		{
																			echo "<div class='commentator'><a href='host_profile.php?host_id=".$row2['user_id']."'><img width='40' height='40' src='".$getdet['image_nm']."'  /></a></div>";
																		}																		
																	
																}
																
												?>
																   <div class="commentator_info">														
												<?php 
																	if($row2['user_type'] == 'club')
																	{
																		?>
																	 	<a href="<?php echo $SiteURL.'host_profile.php?host_id='.$row2['user_id'];?>" class="commentuser">
																	 		<?php echo $getdet['club_name']; ?>
																	 	</a>
																		<span class="commentDate"><?php echo $commentDatetime; ?></span>
																		<div class="commentdesc" ><?php echo $row2['content']; ?></div>
												<?php 
																	}
																	else
																	{
																		?>
																	 	<a href="<?php echo $SiteURL.'profile.php?id='.$row2['user_id'];?>" class="commentuser">
																	 		<?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?>
																	 	</a>
																	 	<span class="commentDate"><?php echo $commentDatetime; ?></span>
																	 	<div class="commentdesc" ><?php echo $row2['content']; ?></div>
												<?php 
																	}
												?>
																</div>
																
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
												<?php
														$row_i++; 
													} 
												?>
											</div>
											<?php 
												if($_SESSION['user_id']!="")
												{
													
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
													<div class="box3 input_comment_area comment_txt">
														<input type="hidden" id="fid_<?php echo $row["forum_id"];?>" value="<?php echo $row["forum_id"];?>">
              <div class="commentwrap">
              	<div style="float:right;">
															<input name="button" class="button" id="co_submit_<?php echo $row["forum_id"]; ?>"  onclick="addform('<?php echo $row["forum_id"];?>');" type="button" value="Add Comment" />
															<img id="comment_load_<?php echo $row["forum_id"]; ?>" src="images/loading-plz.gif" style="margin: -19px 0px 0px 10px; display: none;">
														</div>
              <div class="clear"></div>
														<div class="comment_txt">
															<input name="comment"  onkeydown="javascript:return submitcom(event,'<?php echo $row["forum_id"];?>');"   id="content_<?php echo $row["forum_id"];?>" type="text" placeholder="Write a comment.." value=""/>
														</div>
													</div>
														<div id="comsuc_<?php echo $row["forum_id"];?>" style="float:right; color:green; display:none;">
														</div>
														<div class="pro_error" id="com_error<?php echo $row["forum_id"];?>" style="float:right; color:red; display:none;">
														</div>
													</div>
											<?php } ?>
										</div>										
									</div>

								</div>
								
						<?php 	}  //END  MAIN WHILE LOOP
						}
						else
						{
								echo "<p id='errormessage' style='display:block;'>No Posts Yet.</p>";
						}
					}
						echo '<div class="pagination">';
							if($pager->numPages > 1)
							{
								echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1"><span title="First">&laquo;</span></a>';
								if ($page <= 1)
									echo "<span>Previous</span>";
								else            
									echo "<a href='".$_SERVER['PHP_SELF']."'?page=".($page-1)."'><span>Previous</span></a>";
								echo "  ";
								for ($x=1;$x<=$pager->numPages;$x++){
									echo "  ";
									if ($x == $pager->page)
										echo "<span class='active'>$x</span>";
									else
										echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x."'><span>".$x."</span></a>";
								}
								if($page == $pager->numPages) 
									echo "<span>Next</span>";
								else           
									echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1)."'><span>Next</span></a>";
														
								echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages."'><span title='Last'>&raquo;</span></a>";
							}
						echo "</div>";
						/* FRIENDS QUERY */
					 	$getFriends = mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$_SESSION['user_id']."' AND `user_type` = '$_SESSION[user_type]' AND fs.friend_id != 1 AND fs.friend_id != '$_SESSION[user_id]' AND fs.status IN ('active')
						GROUP BY friend_id ORDER BY id ASC");
						?>
						</div>
  					</div>
<script type="text/javascript">
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
			<div style="display: none;" id="popup3_album_515">
				<span class="b-close-album-515">X</span>
				<div style="height: auto; width: auto;" id="mycontent-album-515">
					<h2 class="shareselect">Select Friends to share Post</h2>
					<div class="sel_all">
						<input type="checkbox" id="SelectALL" onclick="checkAllfriends();" name="selectAll"  /> Select All Friends
					</div>
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
							if($friendResult['profilename'] != "")
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
					?>
						<li>
							<input type="checkbox" name="ShareFriends[]" value="<?php echo $friendID."-----".$fetchFriends['friend_type']; ?>" />&nbsp; <?php echo $friendName;?>
						</li>
				<?php 	}	?>
					</ul>
					<input type="button" id="sharePostfriends" onclick="sharePostFriends();" value="Share" />
					<input type="hidden" id="forumidtoshare" value="" />
				</div>
			</div>
		</article>
   		<div class="adRightBar">
   			<?php 
			$getAds = mysql_query("SELECT * FROM `pagesAds` WHERE `page_name` = 'clubprofile' ORDER BY `adid` DESC LIMIT 0,2 ");
			while ($res = mysql_fetch_assoc($getAds))
			{
		?>
				<a href="<?php if(!empty($res['image_link'])){ echo str_replace("mysittidev.com/", 'mysitti.com/', $res['image_link']);}else{ echo '#';} ?>">
					<img alt="" src="<?php echo $res['image_path'];?>">
				</a>
				<br> <br>
		<?php
			}
		?>
		</div>
	</div>
	<div id="popupUpload" style=""> 
		<div id="mycontent122" style="height: auto; width: auto;"> 
			<span onclick="HideUploadPopEmpty();" class="closebutton" style="float:right; cursor:pointer;">X</span>
			<h1 id="title">Choose Upload Media:</h1>
			<div> 
				<label>From Computer:  </label>
				<input type="file" name="ComputerField" id="ComputerField" onChange="return ValidateFileUpload()" />
			</div>
			<div class="Seperator"> 
				<label>OR</label>
			</div>
			<div> 
				<label>File Url:  </label>
				<input type="text" name="URLField" id="URLField" onclick="emptyComputerField();" /><br/>
				<p style="margin-bottom:0">Paste video link here Example:<br />
				http://www.youtube.com/watch?v=a7SJF3ErXZU <br />
				or<br />
				https://player.vimeo.com/video/27578410
				</p>
			</div>
			<input type="button" onclick="HideUploadPop();" class="button" value="Upload">
		</div>
	</div>

	<div class="b-modal" id="modalpopupUpload" style=""></div>
	<div class="clear"></div>
</div>
<style>
/* SHARE POST CSS */

#popup3_album_515 #sharePostfriends {
  float: left;
  margin: 20px 40%;
  text-align: center;
}
	#popup_adv {
										float: left;
										position: relative;
										width: 100%;
									}
									#inner_popup_adv {
										float: left;
										height: 100%;
										position: absolute;
										width: 100%;
										z-index: 99;
									}	
									#popup3_album_515 {
								  background: #000 none repeat scroll 0 0;
  border: 4px solid #ff0;
  bottom: 0;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  height: auto;
  left: 0;
  margin: auto;
  max-height: 500px!important;
  max-width: 500px!important;
  overflow: auto;
  padding: 10px !important;
  position: fixed;
  right: 0;
  top: 0;
  width: 100% !important;
  z-index: 2;
									}
         
        #popup3_album_515 h1 {
  padding: 10px 0;
  text-transform: uppercase;
  margin-bottom: 10px;
}
									#popup3_album_515 span#close{float:right; margin:10px; color:#fff; font-weight:bold;}
									#popup, #popup2, #popup3_album_515, .bMulti {
										background-color: #000;
										border-radius: 10px;
										box-shadow: 0 0 25px 5px #006099;
										color: #111;
										padding: 25px;
										display: none;
									}
									#popup3_album_515 span.b-close-album-515 { border: none; float: right;color: #fecd07; cursor: pointer;}
										.b-modal1-album-515{display: none;position:fixed; left:0; top:0; height:100%; background:#000; z-index:99; opacity: 0.5; filter: alpha(opacity = 50); zoom:1; width:100%;}
									
									#popup2 #mycontent-album-515 > p {
										color: white;
										font-size: 15px;
										font-weight: bold;
									}
									
									#popup2 #mycontent-album-515 > span {
										color: white;
									}
									#popup3_album_515									{
										z-index: 99999;
										color: #FFF;
									}
									#popup3_album_515 #mycontent-album-515 > p {
									  border-bottom: 1px solid #fff;
									  font-size: 20px;
									  margin-bottom: 10px;
									  padding-bottom: 10px;
									}
									

									#mycontent-album-515 li {
			background: #000 none repeat scroll 0 0;
float: left;
margin: 10px 1%;
max-height: 150px;
/*min-height: 150px;*/
overflow: hidden;
position: relative;
width: 31.3%;
									}
									
					#mycontent-album-515 li img{
      max-width:100%; position:absolute; left:0; right:0; top:0; bottom:0; margin:auto;
     }
									#mycontent-album-515 > ul {
										float: left;
										width: 100%;
									}
         @media only screen and (min-width:540px) {
          					#mycontent-album-515 li { 
width: 48%;
									}
         }

/* END */

.popupContainer{
   top: 47px !important;
}

</style>
<style type="text/css">
#mycontent122 > .button {
	float: left;
	width: 10%;
	margin: 0 30%;
}
#mycontent122 input {
	float: left;
	width: 90%;
}
#mycontent122 p {
	float: left;
	margin: 5px 0 !important;
	width: 100%;
}
#mycontent122 label {
	float: left;
	margin: 5px 0;
	width: 100%;
}
#popupUpload #mycontent122 > div {
	float: left;
	margin: 10px 0;
	width: 100%;
}
#popupUpload > div#mycontent122 {
	color: #fff;
	float: left;
	padding: 20px;
	width: 100%;
}
#popupUpload h1 {
	color: #fecd07;
	float: left;
	font-size: 20px;
	width: 100%;
	text-decoration: underline;
	font-weight: bold;
	margin: 15px 0;
}

#popupUpload {
	position:fixed;
	width:400px;
	height:auto;
	overflow:auto;
	background:#000;
	z-index:2;
	top: 100px !important;
	color: #FFF;
}
#popupUpload span#close {
	float:right;
	margin:10px;
	color:#fff;
	font-weight:bold;
}
#popup, .bMulti {
	background-color: #000;
	border-radius: 10px;
	color: #111;
	padding: 25px;
	display: none;
}
#popupUpload span.b-close {
	border: none;
	float: right;
	min-width:auto!important
}
.b-modal {
	display: none;
	position:fixed;
	left:0;
	top:0;
	height:100%;
	background:#000;
	z-index:99;
	opacity: 0.5;
	filter: alpha(opacity = 50);
	zoom:1;
	width:100%;
}
#popupUpload {
	background-color: #000;
	border: 5px solid #fecd07;
	border-radius: 10px;
	bottom: 0;
	box-shadow: none !important;
	color: #111;
	display: none;
	height: 500px;
	left: 0 !important;
	margin: auto;
	max-width: 400px;
	overflow: auto;
	padding: 0;
	position: fixed;
	right: 0;
	top: 0 !important;
	width: 100%;
	z-index: 2147483647 !important;
}

 @media only screen and (min-width:768px) and (max-width: 1024px)   { 
 .contestFrm.form_format1 li {
  float: left;
  width: 100% !important;
}

 }
 
 @media only screen and (max-width: 767px) {
 article { 
  width: 100% !important;
}
 .contestFrm.form_format1 li {
  float: left;
  width: 100% !important;
}
#popupUpload {max-width:300px; padding:10px;}
.agreebuttons {
  margin-bottom: 32px;
}
 }
 
 @media only screen and (max-width: 540px) {
#popupUpload {max-width:300px; padding:10px; max-height:400px; overflow:auto;}
.agreebuttons {
  margin-bottom: 32px;
} 
 }
</style>
<script type="text/javascript">
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


/* SHARE POST SCRIPT */

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
			//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
			alert('Post shared Publically!');
			return false;
		}
	});
}

function sharepostPrivate (forumid) 
{
	$('#popup3_album_515,#fullOverlay').show();
	$('#forumidtoshare').val(forumid);
	$('.SharingFriendslist li input').each(function(){
		$(this).prop('checked', false);
	});
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
			//window.location.href = '<?php echo $_SERVER["SRCIPT_NAME"];?>?host_id='+id;
			alert('Post shared with selected Friends!');
			$('#popup3_album_515').hide();
			$('#fullOverlay').hide();
			return false;
		}
	});
}



/* END */



  $(function(){
	// Calling Login Form
	$("#login_form").click(function(){
	  $(".social_login").hide();
	  $(".user_login").show();
	  return false;
	});

	// Calling Register Form
	$("#register_form").click(function(){
	  $(".social_login").hide();
	  $(".user_register").show();
	  $(".header_title").text('Register');
	  return false;
	});

	// Going back to Social Forms
	$(".back_btn").click(function(){
	  $(".user_login").hide();
	  $(".user_register").hide();
	  $(".social_login").show();
	  $(".header_title").text('Login');
	  return false;
	});

  });
function emptyComputerField()
{
	$('#ComputerField').val('')
}
function HideUploadPop()
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
			message: '<h1>Uploading Media</h1>'
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
			message: '<h1>Uploading Media</h1>'
		});
		$('#postVideoURL').val($('#URLField').val());
		$.unblockUI({
			onUnblock: function(){
				$('#popupUpload').hide();
				$('#modalpopupUpload').hide();
			}
		});
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



  
	function validate_forum()
	{
		
	   var value = $('#add_post_text').val();
	   if( $('#add_post_text').val() == "" || $('#add_post_text').val() == " " || value < 1)
	   {
			alert( "Please provide post title!" );
			document.forum.forum.focus();
			return false;
		}
	}  

  function newflike(id)
	{
		//Retrieve the contents of the textarea (the content)
		//Build the URL that we will send
		var url = 'f_id='+id+'&from=club_profile';
		//Use jQuery's ajax function to send it
		 $.ajax({
		   type: "POST",
		   url: "flike.php",
		   data: url,
		   success: function(html){
		  //$("#like_"+id).html(html);
			$("#glike_"+id).html("Shouts ( "+html+" ) |");
		  
		   }
		 });
		
		//We return false so when the button is clicked, it doesn't follow the action
		return false;
	}
	
	function ValidateFileUpload(){
			var check_image_ext = $('#ComputerField').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
				alert('Post Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
				$('#ComputerField').val('');
			}else{
				$('#file_upload_successs').show();
			}
			$('#URLField').val('');
	}

	function edit_blog_post(id){
		
		jQuery("html, body").animate({ scrollTop: jQuery("#title").offset().top }, "slow");
		
		jQuery.post('edit_profile_post.php', {'forum_id': id}, function(response){
			
			jQuery("#ad_new_pst").show();
			jQuery("#ad_profile_pst").empty();
			jQuery("#ad_profile_pst").html(response);
			
		});
	}
	
	function delete_blog_post(id){
		
		var r = confirm("Are you sure want to delete !");
		if (r == true) {
	
		 $.get( "deletepost.php?forum_id="+id, function( data ) {
				window.location = "";
			});
		
		}
	}	
</script>



<style>

#lean_overlay{
  opacity: 0.79 !important;
}
.addorremove{
  float: left;
	height: auto;
   
	min-height: 138px;
	min-width: 169px;
	width: auto;
}
.addorremovebutton{
   float: left;
	height: 100%;
	margin-right: 8px;
	width: 24%
}
</style>

<?php include('LandingPageFooter.php'); ?>