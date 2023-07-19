<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
	//Was the form submitted?

	if(isset($_POST['f_id']) && $_POST['from'] == 'city_talk')
	{
		$get_posts_id = mysql_query("SELECT forum_id FROM `forum` WHERE `forum_id` = '".$_POST['f_id']."'");
		$new_f_id = "";
		while($posts_row_id = mysql_fetch_assoc($get_posts_id))
		{
			//Map the content that was sent by the form a variable. Not necessary but it keeps things tidy.
			$f_id = $posts_row_id['forum_id'];
			$who_like_id=$_SESSION['user_id'];
			//Insert the content into database
			//echo "INSERT INTO forum_comment(content,forum_id,user_id)values('".$_POST['content']."','".$forun_id."','".$_SESSION['user_id']."')";
			$mysql = @mysql_query("SELECT * FROM `forum` WHERE forum_id = '$f_id' ");
			$fetchmysql = @mysql_fetch_array($mysql);
			$type= "yes";
			$conntestid = $fetchmysql['contest_id'];
			if($fetchmysql['forum_img'] == "")
			{
				$pathinfo = $fetchmysql['forum_video'];
			}
			else
			{
				$pathinfo = $fetchmysql['forum_img'];	
			}
			
			$getcontestentid = @mysql_query("SELECT * FROM `contestent` WHERE video_name = '".$pathinfo."'");
			$getidarray = @mysql_fetch_array($getcontestentid);
	
			$c_video_id = $getidarray['c_video_id'];
	
			$ThisPageTable ='contest_video_like';
			$ValueArray = array($who_like_id,$c_video_id,$type,$conntestid);
			$FieldArray = array('c_like_user_id','c_video_id','vote_type','constest_id');
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	
	
			mysql_query("INSERT INTO forum_like(forum_id,like_user_id)values('".$f_id."','".$_SESSION['user_id']."')");

			$new_f_id = $f_id;
		}
	
		$sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$new_f_id."'");
		$is_like= @mysql_num_rows($sql_like);
		echo $is_like;		

	}
	elseif(isset($_POST['f_id']) && $_POST['from'] == 'profile')
	{
		$get_posts_id = mysql_query("SELECT forum_id FROM `forum` WHERE `common_identifier` = '".$_POST['f_id']."'");
		$new_f_id = "";
		while($posts_row_id = mysql_fetch_assoc($get_posts_id))
		{
			//Map the content that was sent by the form a variable. Not necessary but it keeps things tidy.
			$f_id = $posts_row_id['forum_id'];
			$who_like_id=$_SESSION['user_id'];
			//Insert the content into database
			//echo "INSERT INTO forum_comment(content,forum_id,user_id)values('".$_POST['content']."','".$forun_id."','".$_SESSION['user_id']."')";
			$mysql = @mysql_query("SELECT * FROM `forum` WHERE forum_id = '$f_id' ");
			$fetchmysql = @mysql_fetch_array($mysql);
			$type= "yes";
			$conntestid = $fetchmysql['contest_id'];
			if($fetchmysql['forum_img'] == "")
			{
				$pathinfo = $fetchmysql['forum_video'];
			}
			else
			{
				$pathinfo = $fetchmysql['forum_img'];	
			}
			
			$getcontestentid = @mysql_query("SELECT * FROM `contestent` WHERE video_name = '".$pathinfo."'");
			$getidarray = @mysql_fetch_array($getcontestentid);
	
			$c_video_id = $getidarray['c_video_id'];
	
			$ThisPageTable ='contest_video_like';
			$ValueArray = array($who_like_id,$c_video_id,$type,$conntestid);
			$FieldArray = array('c_like_user_id','c_video_id','vote_type','constest_id');
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	
	
			mysql_query("INSERT INTO forum_like(forum_id,like_user_id)values('".$f_id."','".$_SESSION['user_id']."')");

			$new_f_id = $f_id;
		}
	
		$sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$new_f_id."'");
		$is_like= @mysql_num_rows($sql_like);
		echo $is_like;		

	}elseif(isset($_POST['from']) && $_POST['from'] == 'club_profile' && isset($_POST['f_id']))
	{
		
		$get_posts_id = mysql_query("SELECT forum_id FROM `forum` WHERE `forum_id` = '".$_POST['f_id']."'");
		$new_f_id = "";
		while($posts_row_id = mysql_fetch_assoc($get_posts_id))
		{
			//Map the content that was sent by the form a variable. Not necessary but it keeps things tidy.
			$f_id = $posts_row_id['forum_id'];
			$who_like_id=$_SESSION['user_id'];
			//Insert the content into database
			//echo "INSERT INTO forum_comment(content,forum_id,user_id)values('".$_POST['content']."','".$forun_id."','".$_SESSION['user_id']."')";
			$mysql = @mysql_query("SELECT * FROM `forum` WHERE forum_id = '$f_id' ");
			$fetchmysql = @mysql_fetch_array($mysql);
			$type= "yes";
			$conntestid = $fetchmysql['contest_id'];
			if($fetchmysql['forum_img'] == "")
			{
				$pathinfo = $fetchmysql['forum_video'];
			}
			else
			{
				$pathinfo = $fetchmysql['forum_img'];	
			}
			
			$getcontestentid = @mysql_query("SELECT * FROM `contestent` WHERE video_name = '".$pathinfo."'");
			$getidarray = @mysql_fetch_array($getcontestentid);
	
			$c_video_id = $getidarray['c_video_id'];
	
			$ThisPageTable ='contest_video_like';
			$ValueArray = array($who_like_id,$c_video_id,$type,$conntestid);
			$FieldArray = array('c_like_user_id','c_video_id','vote_type','constest_id');
			$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
	
	
			mysql_query("INSERT INTO forum_like(forum_id,like_user_id)values('".$f_id."','".$_SESSION['user_id']."')");

			$new_f_id = $f_id;
		}
	
		$sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$new_f_id."'");
		$is_like= @mysql_num_rows($sql_like);
		echo $is_like;		

	}
?>
