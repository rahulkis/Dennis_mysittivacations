<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
	//Was the form submitted?
	if(isset($_POST['id'])){
	//Map the content that was sent by the form a variable. Not necessary but it keeps things tidy.
	$f_id = $_POST['id'];
	$action = $_POST['action'];
	$id = $_POST['f_id'];
	//Insert the content into database
	//echo "INSERT INTO forum_comment(content,forum_id,user_id)values('".$_POST['content']."','".$forun_id."','".$_SESSION['user_id']."')";
		if($action == "disableall" )
		{
			@mysql_query("UPDATE `friends` SET `chat` = '1' WHERE `user_id` = '".$_SESSION['user_id']."'");
			echo '<a onclick="chatsetting("enableall","all","all");" href="javascript:void(0);" class="button">Enable All Chat</a>';
		}
		elseif ($action == "enableall") 
		{
			# code...
			@mysql_query("UPDATE `friends` SET `chat` = '0' WHERE `user_id` = '".$_SESSION['user_id']."'");
			echo '<a onclick="chatsetting("disableall","all","all");" href="javascript:void(0);" class="button">Disable All Chat</a>';
		}
		else
		{
			if($action == "disable")
			{
				@mysql_query("UPDATE `friends` SET `chat` = '1' WHERE `friend_id` = '$f_id' AND `user_id` = '".$_SESSION['user_id']."'");
				@mysql_query("UPDATE `friends` SET `chat` = '1' WHERE `user_id` = '$f_id' AND `friend_id` = '".$_SESSION['user_id']."'");
				echo "<a style='font-size:12px;min-width: 66px; margin: 0px 1px; background: none repeat scroll 0 0 #3b3b3b;' class='button'  id='change_".$id."' href='javascript:void(0);' onclick=\"chatsetting('enable','$f_id','$id');\">Enable Chat</a>";
			}
			else
			{
				@mysql_query("UPDATE `friends` SET `chat` = '0' WHERE `friend_id` = '$f_id' AND `user_id` = '".$_SESSION['user_id']."'");
				@mysql_query("UPDATE `friends` SET `chat` = '0' WHERE `user_id` = '$f_id' AND `friend_id` = '".$_SESSION['user_id']."'");
				echo "<a style='font-size:12px;min-width: 66px; margin: 0px 1px; background: none repeat scroll 0 0 #3b3b3b;' class='button'  id='change_".$id."' href='javascript:void(0);' onclick=\"chatsetting('disable','$f_id','$id');\">Disable Chat</a>";
			}
		
		}	
	}
	
	
	
?>