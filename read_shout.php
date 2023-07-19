<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

if(isset($_REQUEST['id']))
{$userID=$_REQUEST['id'];
}     
else 
{
	$userID=$_SESSION['user_id'];	
}

$titleofpage=" Read Shout";


$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="update")
	{
	$message="Coupon Updated Sucessfully";
	}
}
		
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=mysql_fetch_assoc($sql_fe);
?>
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1; maximum-scale=1.0; user-scalable=0;"/>
<meta name="viewport" content="initial-scale = 1.0, user-scalable = no">
<meta name="google-site-verification" content="o-g5OxxDOWX2F__eELEb5UVS1lDerXIIc1hVhtJ4PpE" />
	
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<!-- ======== Include Main Stylesheet ===============  -->
<link href="css/jquery.bxslider.css" rel="stylesheet" type="text/css">
<link href="css/stylesNew.css" rel="stylesheet"  type="text/css">
<link href="css/v2style.css" rel="stylesheet" type="text/css">
<link href="css/v1style.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">

<link href="css/media.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jukebox.css" />
<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
<link href="css/landingPagestyle.css" rel="stylesheet" type="text/css">
<link href="css/landingPageresponsive.css" rel="stylesheet" type="text/css">
<link href="css/landingPagejquery.bxslider.css" rel="stylesheet" type="text/css">

<!-- ======== Include Main Javascript Library ===============  -->

<script src="lightbox/js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-migrate-1.0.0.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js" type="text/javascript"></script>
<script src="js/datetimepicker/jquery.datetimepicker.js"></script>
<script src="js/add.js" type="text/javascript"></script>

<script src="autocomplete/jquery.ajaxcomplete.js"></script>
<script type="text/javascript" src="QapTcha-master/jquery/jquery-ui.js"></script>
<script src="lightbox/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="lightbox/js/jquery.smooth-scroll.min.js"></script>

<script src="js/custom.js"></script>
<script src="js/functions.js"></script>
<script type="text/javascript" src="jwplayer-7.2.4/jwplayer.js"></script>

<script type="text/javascript">jwplayer.key="gyFk8oXM74FH6kGJy/f6ihbnSWglj00PKUXyvQ==";</script>
<script type="text/javascript" src="js/chat.js"></script>
<script src="js/jquery.blockUI.js"></script>
<link rel="stylesheet" href="css/new_portal/smk-accordion.css" />
<script type="text/javascript" src="js/new_portal/smk-accordion.js"></script>
<link rel="stylesheet" href="lightbox2-master/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="lightbox2-master/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" href="css/jslider.css" type="text/css">
	<script type="text/javascript" src="js/jshashtable-2.1_src.js"></script>
	<script type="text/javascript" src="js/jquery.numberformatter-1.2.3.js"></script>
	<script type="text/javascript" src="js/tmpl.js"></script>
	<script type="text/javascript" src="js/jquery.dependClass-0.1.js"></script>
	<script type="text/javascript" src="js/draggable-0.1.js"></script>
	<script type="text/javascript" src="js/jquery.slider.js"></script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDFLaJwxTIGpZmwfpbEyOU5XZglUq6-5iM&libraries=places"></script>
<script src="../getCity/geo-contrast.jquery.js" type="text/javascript"></script>

<link href="datepick/foundation-datepicker.css" rel="stylesheet" type="text/css">
<script src="../datepick/foundation-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/js/Jcrop.js"></script>
<link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.css" type="text/css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="emoji/emoji.css" type="text/css">
<script src="emoji/config.js"></script>
  <script src="emoji/util.js"></script>
  <script src="emoji/jquery.emojiarea.js"></script>
  <script src="emoji/emoji-picker.js"></script>

<meta name='B-verify' content='fc452fae810405f1fa3a7dba61393529df536296' />


 <?php
 if(isset($_GET['id']))
 {
   	$sql_up=mysql_query("select * from shouts where id='".$_GET['id']."'");
   	$op_shout=mysql_fetch_assoc($sql_up);
   	//print_r($op_shout);exit;

   	mysql_query("UPDATE `user_to_content` SET `is_read` = '1' WHERE `user_id` = '$_SESSION[user_id]' AND `cont_type` = 'shout' AND `user_type` = '$_SESSION[user_type]'  ");




 }
		$userID = $_SESSION['user_id'];
	/******************/

// if(!isset($_SESSION['user_id']))
// {
// 	include('PublicProfileHeader.php');
// }
// else
// {
// 	include('NewHeadeHost.php');
// }


?>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 

// echo "<pre>"; print_r($_SESSION); exit;

		// if($_SESSION['user_type'] == 'club')
		// {
		// 	if(isset($_SESSION['subuser']) && $_SESSION['subuser'] == '1' )
		// 	{
		// 		include('sub-right-panel.php');
		// 	}
		// 	else
		// 	{
		// 		include('club-right-panel.php');
		// 	}
		// }
		// else
		// {
		// 	include('friend-right-panel.php');
		// }
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
						<h3 id="title" class="botmbordr">Shout Out</h3>
				
				<div class="profileright">
					<div id="profile_box">
	   <form name="shout_out" id="shout_out" class="read_shout" method="post"   enctype="multipart/form-data">      
		  
		  
		  <div class="row">
			<span class="label">Shout By:</span>
			<?php
			if($op_shout['user_type'] == "user"){
				
				$get_shout_udata = mysql_query("SELECT first_name, last_name, profilename FROM user WHERE id = '".$op_shout['user_id']."'");
				$fetch_shout_udata = mysql_fetch_assoc($get_shout_udata);
				
				if(empty($fetch_shout_udata['profilename'])){
					
					$shout_user_name = $fetch_shout_udata['first_name']." ".$fetch_shout_udata['last_name'];
					
				}else{
					
					$shout_user_name = $fetch_shout_udata['profilename'];
					
				}
			}
			
			if($op_shout['user_type'] == "club"){	
				
				$get_shout_udata = mysql_query("SELECT club_name, first_name, last_name FROM clubs WHERE id = '".$op_shout['user_id']."'");
				$fetch_shout_udata = mysql_fetch_assoc($get_shout_udata);
				
				if(empty($fetch_shout_udata['club_name'])){
					
					$shout_user_name = $fetch_shout_udata['first_name']." ".$fetch_shout_udata['last_name'];
					
				}else{
					
					$shout_user_name = $fetch_shout_udata['club_name'];
					
				}
			}			
			?>
			<!--<span class="formw"> <?php echo $op_shout['shout_title']; ?></span>-->
			<span class="formw"> <?php echo $shout_user_name; ?></span>
		  </div>

			<div class="row">
			<span class="label">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<span class="formw"> <?php echo $op_shout['shout']; ?></span>
		  </div>

		  <div class="row">
			<span class="label">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<span class="formw">
		  
				<? if($op_shout['shout_image'] != ""){
					
					$explode_img = explode("upload/shout/images/" , $op_shout['shout_image']);
					?>
					
					<img src="upload/shout/images/thumb_<?php echo $explode_img[1]; ?>" width="" height="">
				
				<?php }elseif($op_shout['shout_video'] != ""){ ?>
				
					<a  id="ve_<?php echo $op_shout["id"];?>" href="#dialogx<?php echo $op_shout["id"];?>" name="modal"></a>
				
					<a href="javascript:void(0);"  style="width:300px;">
						<div id="a<?php echo $op_shout["id"];?>"></div>
							<script type="text/javascript">
							jwplayer("a<?php echo $op_shout["id"];?>").setup({
							file: "<?php echo $op_shout["shout_video"];?>",
							height : 250 ,
							width: 300
							});
							</script>
					</a>
					
				<?php }
				
				//else{
				//
				//	echo "No Media Added";
				//
				//		}
						?>
		  </span>
		 </div>
			
	   </form>	
	  
		
		</div>
			   
 <div style="float: right;"><a class="button" href="shout.php">Back</a></div>                   
					</div>
					</div>
				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php //include('Footer.php') ?>
