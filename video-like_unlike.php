<?
include("Query.Inc.php");
$Obj = new Query($DBName);

$like=$_GET['action'];
$video_id=$_GET['video_id'];
$who_like_id=$_GET['who_like_id'];


if($like=="like")
{
	$ThisPageTable='like_img_video';
	$ValueArray = array($who_like_id,$video_id);
	$FieldArray = array('like_user_id','video_id');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	
	$sel_like=mysql_query("select count(like_id) as tot_like  from like_img_video where video_id='".$video_id."'");
    $fech_like=@mysql_fetch_array($sel_like);
	?>
	 <span id="vid_<?php echo $video_row["video_id"]; ?>">
    <a href="javascript:void(0);" onclick="makelike('unlike','<?php echo $video_id; ?>','<?php  echo $who_like_id ?>');">Unlike </a> 
   , <?php echo $fech_like['tot_like'] ?>  People Likes</span>
	
    <?php
}
else
{
		
	$del_id = $_REQUEST['video_id'];
    $delete = "delete from like_img_video where video_id ='".$video_id."' AND like_user_id='".$who_like_id."'";
	@mysql_query($delete);
	
	$sel_like=mysql_query("select count(like_id) as tot_like  from like_img_video where video_id='".$video_id."'");
    $fech_like=@mysql_fetch_array($sel_like);
	
	?>
	 <span id="vid_<?php echo $video_id; ?>">
    <a href="javascript:void(0);" onclick="makelike('like','<?php echo $video_id; ?>','<?php  echo $who_like_id ?>');">Like </a> 
   , <?php echo $fech_like['tot_like'];?>  People Likes</span>
   

    <?php
}
?>