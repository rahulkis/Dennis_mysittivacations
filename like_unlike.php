<?
include("Query.Inc.php");
$Obj = new Query($DBName);

$like=$_GET['action'];
$img_id=$_GET['img_id'];
$who_like_id=$_GET['who_like_id'];
$img_user_id=$_GET['img_user_id']; 
 
 
$sql_total_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE img_id='".$img_id."'");
$total_like= mysql_num_rows($sql_total_like);
if($like=="like")
{
	$ThisPageTable='like_img_video';
	$ValueArray = array($who_like_id,$img_user_id,$img_id);
	$FieldArray = array('like_user_id','photo_user_id','img_id');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	$sql_total_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE img_id='".$img_id."'");
	$total_like= mysql_num_rows($sql_total_like);
	?>
	<label id='like' onclick='like_unlike("unlike",<?php echo $img_id; ?>,<?php echo $who_like_id; ?>,<?php echo $img_user_id; ?>)'><?php echo $total_like ?> Unlike</label>|<?php echo $img_id; ?>
    <?php
}
else
{
	$del_id = $_REQUEST['del_id'];
    $delete = "delete from like_img_video where img_id ='".$img_id."' && like_user_id='".$who_like_id."'";
	mysql_query($delete);
	$sql_total_like= mysql_query( "SELECT `like_user_id` FROM `like_img_video` WHERE img_id='".$img_id."'");
	$total_like= mysql_num_rows($sql_total_like);
	?>
	<label id='like' onclick='like_unlike("like",<?php echo $img_id; ?>,<?php echo $who_like_id; ?>,<?php echo $img_user_id; ?>)'><?php echo $total_like ?> Like</label>|<?php echo $img_id; ?>
    <?php
}
?>