<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
 
 if(isset($_GET['id']))
 {
   $sql_up=@mysql_query("select * from shouts where id='".$_GET['id']."'");
    $q_up=@mysql_query("update shouts set is_read='1' where id='".$_GET['id']."'");
   $op_shout=@mysql_fetch_assoc($sql_up);
   // mark challenge as Read 
//echo "update user_to_content set is_read='1' where cont_id='".$_GET['id']."' AND cont_type='shout' AND user_id='".$_SESSION['user_id']."'";
if($_SESSION['user_id']!=$op_shout['user_id']){
   $sql_read=mysql_query("update user_to_content set is_read='1' where cont_id='".$_GET['id']."' AND cont_type='shout' AND user_id='".$_SESSION['user_id']."'");
  }
 //echo "<script>opener.location.reload(true);</script>";	
// 
   //print_r($op_shout);exit;
 }
        $userID = $_SESSION['user_id'];
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="text/css" rel="stylesheet" href="../css/style_popup.css" />
<link rel="stylesheet" type="text/css" href="../css/new_portal/style.css" />
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>
<style>
.popupContainer {
	background:  #efefef;
	border: 1px solid #1C50B3;
	bottom: 0;
	color: #fff;
	font-size: 12px;
	left: 0;
	margin: auto;
	max-height: 600px;
	max-width: 400px !important;
	overflow-x: auto;
	position: absolute;
	right: 0;
	top: 0;
}
.user_register {
  display: block;
  word-wrap: break-word;
  color: #333;
}
.popupHeader { 
  padding: 10px 0; 
}
.user_register a > div {border:1px solid #333;}

</style>
 <div id="modal" class="popupContainer" >
		<header class="popupHeader">
			<span class="header_title">View Shout</span>

		</header>
		<section class="popupBody">
			<!-- Social Login -->
			<div class="user_register">
          

               			  <label><strong>Shout By:</strong></label>
						  
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
						  
						  <?php echo $shout_user_name; ?>
						  
                          <?php //echo $op_shout['shout_title']; ?>
                       <p class="brd"> </p>
                        <label><strong>&nbsp;&nbsp;&nbsp;&nbsp;</strong></label>
                        <?php echo $op_shout['shout']; ?>
                          <p class="brd"> </p>
                        <br> 
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>

				<? if($op_shout['shout_image'] != "" ||  !empty($op_shout['shout_thumb']) ){
					
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
							height : 250,
							width: 300
							});
							</script>
					</a>
					
				<?php }	?>
             
                      <p class="brd"> </p>
                      <div id="closewindow"><input type="button" onclick="javacript:self.close();" class="button" value="Close Window" /></div>
			</div>

		</section>
	</div>
 

               
