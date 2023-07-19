<?php
ob_start();
include("Query.Inc.php");
$Obj = new Query($DBName);


	 
	 
//$titleofpage="Profile";
include('LoginHeader.php');

$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
//include '../googleplus-config.php';

// ini_set("display_errors", "1");
// error_reporting(E_ALL);

if(!isset($userID)){ $Obj->Redirect($SiteURL); }

//include("CheckLogIn_con.Inc.php");
$who_like_id=$_SESSION['user_id'];
$hostID=$_GET['hostID'];
$contest_id=$_GET['cont_id'];

// mark challenge as Read 
   $sql_read=mysql_query("update user_to_content set is_read='1' where cont_id='".$contest_id."' AND cont_type='content' AND user_id='".$_SESSION['user_id']."' AND user_type = '$_SESSION[user_type]' ");
// 




if(isset($_GET['id']))
{
	$UID=$_GET['id']; 
}
else 
{
	$UID=$_SESSION['user_id'];	
}
	
	$sql = "select * from `user` where `id` = '".$UID."'";
	$userArray = $Obj->select($sql) ; 
	$first_name=$userArray[0]['first_name']; 
	$last_name=$userArray[0]['last_name'];
	$zipcode=$userArray[0]['zipcode'];
	$state=$userArray[0]['state'];
	$country=$userArray[0]['country'];
	if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
	$city=$userArray[0]['city'];
	$email=$userArray[0]['email'];
	$image_nm=$userArray[0]['image_nm'];
	$phone=$userArray[0]['phone'];
	/**********************************/
	 
	 $titleofpage=" ".$first_name." ".$last_name." Friendly Challenge";

?>


<!-- Auto Scroll -->

      
    <script>
		function changecity(val)
		{
			$.get('current_contests.php?city_id='+val, function(data) {
				window.location='current_contests.php';
			});
		}
		function changecity2()
		{
			val=$('#city_name').val();
			$.get('set-session.php?city_id='+val, function(data) {
				window.location='current_contests.php';
			});
		}

		function likefun(val1, val2, vcount,host_id)
		{
		$.get('current_contests.php?c_video_id='+val1+'&action=like&video_user_id='+val2, function(data) {
		window.location='host_contests.php?cont_id='+val2+'&host_id='+host_id;
		});
		$('#like_'+val1).html('Shout');
		 vcount++;
		$('#like_count_'+val1).html(vcount);
		}
    </script>
    
  <script type="text/javascript">
function isLogin() {
  if (confirm("To like video Please login.")) {
   document.location = "login.php";
  }
}
</script>  



<style>
#mask {
  position:absolute;
  left:0;
  top:0;
  z-index:500;
  background-color:#000;
  display:none;
}
  
 .window {
	position:fixed;
	left:0;
	top:0;
	display:none;
  	z-index:9000;
	height: 400px;
	width: 600px;
}  

</style>

<!-- Auto Scroll -->

<?php

if($_GET['cont_id'])
{	
	 $sql="SELECT * FROM `contest` where `status`='1' and contest_id='".$_GET['cont_id']."' ORDER BY `contest_id` ASC limit 1";
}

$contest_list = $Obj->select($sql) ;
if(!empty($contest_list)){ $result_found =  'yes';}else{ $result_found =  'no';}
$contest_img=$contest_list[0]['contest_img'];
$contest_desc=$contest_list[0]['contest_desc'];
 $contest_id=$contest_list[0]['contest_id']; 
$contest_rule=$contest_list[0]['contest_rule'];
 $_SESSION['user_id']." ".$contest_list[0]['user_id'];
  
    $sql_up=@mysql_query("update contest set is_read='1' where contest_id='".$_GET['cont_id']."' ");


if(isset($_REQUEST['c_video_id']))
{
	if(!isset($_SESSION['user_id']))
	{
		$Obj->Redirect("login.php");
		die();	
	}
	$c_video_id = $_REQUEST['c_video_id'];
	$action=$_REQUEST['action'];
	$video_user_id=$_REQUEST['video_user_id'];		
	$who_like_id=$_SESSION['user_id'];
	if($action=="like")
	{
	if($who_like_id!='')
	{
	$ThisPageTable='contest_video_like';
	$ValueArray = array($who_like_id,$video_user_id,$contest_id,$c_video_id);
	$FieldArray = array('c_like_user_id','c_video_user_id','constest_id','c_video_id');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	}
	else
	{
	$Obj->Redirect("login.php");
	}
	}
	else
	{
	$c_video_id = $_REQUEST['c_video_id'];
	$delete = "delete from contest_video_like where c_video_id ='".$c_video_id."' && c_like_user_id='".$who_like_id."'";
	mysql_query($delete);			
	}
	$Obj->Redirect("current_contests.php");
	$count_like_qry= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$c_video_id."'");
	$count_like=@mysql_num_rows($count_like_qry);
}

?>

<div class="v2_container">
  <div class="v2_inner_main">
	
	<?php
	if($_SESSION['user_type'] == 'user')
	{
		include('friend-right-panel.php');  
	}
	else
	{
		include('club-right-panel.php');  	
	}
	
	?>
	
			<article class="forum_content v2_contentbar">
				<div class="v2_rotate_neg">
					<div class="v2_rotate_pos">
						<div class="v2_inner_main_content">
						
									<div id="title" class="v2challenge_title">
									 <h1 class="h1"> <?php echo $titleofpage; ?> </h1>	 
									</div>
									<div class="profileright v2_challenge">
								<?php
										$imgpath= strstr($contest_img,"contest_img");

										if($result_found == 'yes')
										{
								?>
											<div class="content1asd" id="mysitticontestpage" style="color:white;">
												<div class="pic2">
													<?php if($imgpath){ ?>
													
													<?php $explode = explode('contest_img/' , $contest_img); ?>
													
															<a href="<?php echo $SiteURL.$imgpath; ?>" rel="lightbox"><img src="contest_img/thumb_<?php echo $explode[1]; ?>" width="200px" height="200px" /></a>
													<?php }else{ ?>
															<img src="<?php echo $SiteURL; ?>images/image_not_available.png" width="200px" height="200px" />
													<?php } ?>
												</div>
												<div class="content_txt" style=" ">
													<h1>Contest Description</h1>
													<p><?php echo substr($contest_desc, 0, 500); ?> <?php if(strlen($contest_desc)>500) { ?><p ><a style="color:#F00" href="javascript:vois(0)" onclick="javascript:window.open('mysitti_contests_more.php?contid=<?php echo $_GET['cont_id']; ?>#dec','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" >... Read More</a></p> <?php } ?></p>
													<h1>Rules </h1>
													<p><?php echo substr($contest_rule, 0, 500); ?><?php if(strlen($contest_rule)>500) { ?><p ><a style="color:#F00" href="javascript:vois(0)" onclick="javascript:window.open('mysitti_contests_more.php?contid=<?php echo $_GET['cont_id']; ?>#rules','_blank','toolbar=yes, scrollbars=yes, resizable=yes, top=400, left=400, width=600, height=600');" >... Read More</a></p> <?php } ?> </p>
												</div>
											</div>
												<div class="v2_enter_contest">
												<?php
												$check_challenge_user = mysql_query("SELECT * FROM user_to_content WHERE user_id = '".$_SESSION['user_id']."' AND cont_id = '".$_GET['cont_id']."'");
												$check_u = mysql_num_rows($check_challenge_user);
												if($check_u > 0){
												?>
													<a href="#" onclick="window.location='contestForm_user.php?id=<?php echo $contest_id; ?>'"   class="button">Enter Challenge</a>
												<?php } ?>	
													<div style="float:right; margin-left: 10px;"><a class="button" href="<?php if($_SESSION['user_type'] == "user"){ echo 'user_challenge.php';}else{ echo 'user_challenge.php?cont_id='.$_GET['cont_id'].'&id='.$_GET['id'];}?>">Back </a></div>
												</div>
											<div class="content2" id="mysitticontestpage">
												<h1 id="title">Friends </h1>
												

												
											</div>
							<!--
											<h2 style="color:#0F0;">
											<?php 
												if(isset($_SESSION['msg']) && $_SESSION['msg']!='')
												{
													//echo $_SESSION['msg'];
													echo '<script type="text/javascript">alert("Your entry has been added successfully in current contest.");</script>';
													unset($_SESSION['msg']);
												}
											?>
											</h2>  --> 
											<div class="content3" id="mysitticontestpage">
												<div class="sub_content">
							<?php
							
												$query_string ="SELECT c.* ,u.first_name,u.last_name
																FROM contestent as c LEFT JOIN user as u on c.user_id=u.id
																WHERE c.contest_id ='".$contest_id."'";
												$result = mysql_query($query_string);			  
												$count_records = mysql_num_rows($result);
												while($video = mysql_fetch_array($result))
												{
											?>
													<div class="s_listingproduct">
														<div class="modal v2_listing_thumb">
														<?php /*?><div>Content Type: <? echo $video['contest_type']; ?></div><?php */?>
											<?php 
															if($video['contest_type']=='video')
															{
											?>
																<div id="a<?php echo $video["c_video_id"];?>">Loading the player...</div>
																<script type="text/javascript">                            
																	jwplayer("a<?php echo $video["c_video_id"];?>").setup({
																	file: "<?php echo $video["video_name"];?>",
																	height : 200 ,
																	width: 250
																	});                            
																</script>
										<?php 				}
															else 
															{ 
										?>
																<a href="<?php echo $SiteURL.$video["video_name"];?>" rel="lightbox"><img src="<?php echo $SiteURL.$video["video_name"];?>"  ></a>
										<?php 				}
										?>
														</div>
										<?php   
														// count yes vote
														$count_yes= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$video["c_video_id"]."' AND vote_type='yes'");
														$cnt_yes=@mysql_num_rows($count_yes);
														//count no vote
														$count_no= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$video["c_video_id"]."' AND vote_type='no'");
														$cnt_no=@mysql_num_rows($count_no);
														
														$sql_like1 = "SELECT `c_like_user_id` , vote_type   FROM `contest_video_like` WHERE `c_like_user_id` = '".$_SESSION['user_id']."' AND c_video_id='".$video["c_video_id"]."' ";
														$sql_like= mysql_query($sql_like1) or die(mysql_error());
														$is_like= mysql_fetch_assoc($sql_like);
										?>
														<div class="box5 v2_listing_desc">
															<div class="username1">Post By:  <?php echo $video["first_name"]." ".$video["last_name"]; ?> </div>
															<div class="v2_shoutss">
																
																<span id="yes_<?php echo $video["c_video_id"]; ?>">  
										<?php 					if($is_like['vote_type']!='yes') 
																{
										?>
																	<a href="javascript:void(0);" style="color: ; text-decoration:none;" onclick="count_vote('<?php echo $video["c_video_id"]; ?>','yes','<? echo $contest_id; ?> ');"> Shout </a>
									<?php 						}
																else
																{
									?> 								Shout 
									<?php 						}
									?>							<?PHP echo $cnt_yes; ?>
																</span>
																<? /*<span id="no_<?php echo $video["c_video_id"]; ?>"> <?PHP echo $cnt_no; ?> 
									<?php 						if($is_like['vote_type']!='no')
																{ 
									?>
																	<a href="javascript:void(0);" style="text-decoration:none;" onclick="count_vote('<?php echo $video["c_video_id"]; ?>','no');"> No </a>
									<?php 						}
																else
																{
									?> 								No
									<?php 						}
									?>
																</span><? */ ?>
															</div>
								
									
									
														</div>
													</div><!-- END DIV BOX4 -->
					<?php 						}				?>
					<?php // close while loop
												if($count_records == 0)
												{
													echo 'No contestant found.';
												}
							?>
												</div> <!-- END sub_content -->
									
								
							
							
											</div><!-- END content3 -->
									</div><!-- END profileright -->
								
							<?php }else{?>
						   <div class="content1" style="color:white;">       
							<div class="content_txt" style="margin-top:12px;">
							<h1>No Record Found</h1>
							</div>
							</div>
						
							<?php }?>
							

											
						
						</div>
					</div>
				</div>
			</article>
	</div>
</div>

    <script language="javascript">
	function count_vote(id,type,contid)
	{
		$('#'+type+'_'+id).html('loading...'); 
	  	$.get('vote.php?c_id='+id+'&type='+type+"&contid="+contid, function(data) {
	  		$('#'+type+'_'+id).html(data); 
		});
	}
	</script>

    <?php include('Footer.php'); ?>