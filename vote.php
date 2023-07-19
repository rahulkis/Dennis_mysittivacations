<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
//include("CheckLogIn_con.Inc.php");
$who_like_id=$_SESSION['user_id'];
?>

<?php

if(isset($_REQUEST['c_id']))
{
	$c_video_id = $_REQUEST['c_id'];
	$who_like_id=$_SESSION['user_id'];
	$conntestid = $_REQUEST['contid'];
	$user_type = $_SESSION['user_type'];
	$type=$_REQUEST['type'];
	if($who_like_id!='')
	{
	if($type=='yes')
	{
	 mysql_query("delete from contest_video_like where vote_type='no' AND c_like_user_id='".$_SESSION['user_id']."' AND c_video_id='".$c_video_id."'");
	}else
	{
		 mysql_query("delete from contest_video_like where vote_type='yes' AND c_like_user_id='".$_SESSION['user_id']."' AND c_video_id='".$c_video_id."'");
	}
	$ThisPageTable='contest_video_like';
	$ValueArray = array($who_like_id,$c_video_id,$type,$conntestid,$user_type);
	$FieldArray = array('c_like_user_id','c_video_id','vote_type','constest_id','user_type');
	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	$count_yes= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$c_video_id ."' AND vote_type='yes'");
    $cnt_yes=@mysql_num_rows($count_yes);
    $count_no= @mysql_query("SELECT * FROM `contest_video_like` WHERE `c_video_id` = '".$c_video_id ."' AND vote_type!='yes'");
     $cnt_no=@mysql_num_rows($count_no);
	//echo $cnt_no." ".ucfirst($type);

    $testquery = @mysql_query("SELECT * FROM `forum` WHERE `contest_id` = '".$conntestid."' AND user_id = '".$who_like_id."' ");
    $fetchtestquery  =@mysql_fetch_array($testquery);
    $fid = $fetchtestquery['forum_id'];
    @mysql_query(" INSERT INTO `forum_like` (`forum_id`,`like_user_id`) VALUES ('$fid','$who_like_id') ");


	
	?>
	 <span id="yes_<?php echo $c_video_id; ?>"> 
                <?php if($type!='yes') { ?>
                <a href="javascript:void(0);" style="text-decoration:none;" onclick="count_vote('<?php echo $c_video_id; ?>','yes','<? echo $conntestid;?>');"> Shouts </a>
                <?php }else{ ?> Shouts <?php } ?><?PHP echo $cnt_yes; ?> 
                </span>
               <!-- ,<span id="no_<?php echo $c_video_id; ?>"> <?PHP echo $cnt_no; ?> 
                <?php if($type!='no') { ?>
                <a href="javascript:void(0);" style="text-decoration:none;" onclick="count_vote('<?php echo $c_video_id ?>','no','<? echo $conntestid;?>');");"> No </a>
                <?php }else{ ?> No <?php } ?>
                </span>-->
	<?}
	
	
	 
}
   ?>
