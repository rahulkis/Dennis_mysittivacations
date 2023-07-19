<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
	//Was the form submitted?
if(isset($_POST['content'])){
		
		$get_ci = mysql_query("SELECT common_identifier FROM forum WHERE forum_id = '".$_POST['forun_id']."'");
		$ci_val = mysql_fetch_assoc($get_ci);
		$comi_value = $ci_val['common_identifier'];
		
		$get_posts = mysql_query("SELECT forum_id FROM forum WHERE common_identifier = '".$comi_value."'");
		$currentDAte = date('Y-m-d H:i:s');
		while($p_row = mysql_fetch_assoc($get_posts))
		{
	
				//Map the content that was sent by the form a variable. Not necessary but it keeps things tidy.
				$content = $_POST['content'];
				$forun_id = $p_row['forum_id'];
				
				//Insert the content into database
				mysql_query("INSERT INTO forum_comment(added_date,content,forum_id,user_id,user_type)values('$currentDAte','".$content."','".$forun_id."','".$_SESSION['user_id']."','".$_SESSION['user_type']."')");
			
				//Redirect the user back to the index page
				//header("Location:forum.php");
				
				$get_id  = mysql_query("SELECT * FROM forum_comment WHERE user_id = '".$_SESSION['user_id']."' AND content = '".$content."' ORDER BY id DESC LIMIT 0,1");
				$get_last_id = mysql_fetch_assoc($get_id);
				
				$l_id = $get_last_id['id'];
				
				$find_count = mysql_query("SELECT fc.*,u.first_name,u.last_name,u.image_nm FROM forum_comment as fc left join user as u on(u.id=fc.user_id) where fc.id='".$l_id."' ORDER BY fc.id DESC");
		}
	

	/*Doesn't matter if the form has been posted or not, show the latest posts*/
	
	//Find all the notes in the database and order them in a descending order (latest post first).
	$find = mysql_query("SELECT fc.*,u.first_name,u.last_name,u.image_nm FROM forum_comment as fc left join user as u on(u.id=fc.user_id) where fc.forum_id='".$forun_id."' ORDER BY fc.id DESC");
	//Setup the un-ordered list
	$count_comments = mysql_num_rows($find);
	$row = mysql_fetch_array($find);
	//echo "<pre>"; print_r($row); exit;
	?>
<?php echo $count_comments;?>+++++++++
	<?php
	//Continue looping through all of them
	//while($row = mysql_fetch_array($find))
	//{
		$commentDatetime = date('F j, g:i a',strtotime($row['added_date']));
		if($row['user_type'] == 'user')
		{
			$getdataq = mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['user_id']."' ");
			$fetchdataq = mysql_fetch_array($getdataq);

		

			if($fetchdataq['image_nm']!="")
			{
			 	$img=$fetchdataq['image_nm'];
			}
			else
			{
			  	$img="images/pic1.jpg";
			}
			//For each one, echo a list item giving a link to the delete page with it's id.
			?>
			<div class='box3 postNewComments hide_<?php echo $forun_id;?> comment_box c_box_<?php echo $row['id']; ?>'>
   <div class="commentator">
	
	<?php if($row['user_type'] == "user"){ ?>
	
		<a href="profile.php?id=<?php echo $row['user_id']; ?>">	
	
	<?php }elseif($row['user_type'] == "club"){ ?>
	
		<a href="host_profile.php?host_id=<?php echo $row['user_id']; ?>">		
		
	<?php } ?>

	<img width='40' height='40' src="<?php echo $SiteURL.$img; ?>" />
	</a>
   </div>
   <p class="commentator_info">
		<?php	
			if($_SESSION['user_id'] != '')
			{
				//echo "<img onClick=\"delete_comment('".$row['id']."')\"; width='16px' height='16px' src='images/del.png' style='float: right; cursor: pointer;'>"; 
			}
			
		if($row['user_type'] == "user"){
		
			echo "<a href='profile.php?id=".$row['user_id']."' class='commentuser'>".$fetchdataq['first_name']." ".$fetchdataq['last_name']."</a><span class='commentDate'>".$commentDatetime."</span><div class='clear'></div>"."<div class='comments'>".$row['content']."</div>"."</p>";		
	
		 }elseif($row['user_type'] == "club"){

			echo "<a href='host_profile.php?host_id=".$row['user_id']."' class='commentuser'>".$fetchdataq['first_name']." ".$fetchdataq['last_name']."</a><span class='commentDate'>".$commentDatetime."</span><div class='clear'></div>"."<div class='comments'>".$row['content']."</div>"."</p>";
		}			
			

			
			
			if($_SESSION['user_id'] != '' && $row['user_id'] == $_SESSION['user_id'] && $row['user_type'] == $_SESSION['user_type'])
			{
				echo "<img class='delete_Comment' onClick=\"delete_comment('".$row['id']."', 'show_cm_".$forun_id."');\" width='16px' height='16px' src='images/del-notification.png' style='float: right; cursor: pointer; border: medium none;'>"; 
			}
			
			echo "</div>";
			
		}
		else
		{
			$getdataq = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$row['user_id']."' ");
			$fetchdataq = mysql_fetch_array($getdataq);

		

			if($fetchdataq['image_nm']!="")
			{
			 $img=$fetchdataq['image_nm'];
			}
			else
			{
			  $img="images/pic1.jpg";
			}
			//For each one, echo a list item giving a link to the delete page with it's id.
			?>
				<div class='box3 postNewComments hide_<?php echo $forun_id;?> comment_box c_box_<?php echo $row['id']; ?>'>
					<div class="commentator">
						<!-- <img width='40' height='40' src="<?php echo $SiteURL.$img; ?>" /> -->
						<?php if($row['user_type'] == "user"){ ?>
	
							<a href="profile.php?id=<?php echo $row['user_id']; ?>">	
						
						<?php }elseif($row['user_type'] == "club"){ ?>
						
							<a href="host_profile.php?host_id=<?php echo $row['user_id']; ?>">		
							
						<?php } ?>

							<img width='40' height='40' src="<?php echo $SiteURL.$img; ?>" />
						</a>
					</div>
     <p class="commentator_info">
		<?php

		if($row['user_type'] == "user"){
		
			echo "<a href='profile.php?id=".$row['user_id']."' class='commentuser'>".$fetchdataq['club_name']."</a><span class='commentDate'>".$commentDatetime."</span><div class='clear'></div>"."<div class='comments'>".$row['content']."</div>"."</p>";		
	
		 }elseif($row['user_type'] == "club"){
		
			echo "<a href='host_profile.php?host_id=".$row['user_id']."' class='commentuser'>".$fetchdataq['club_name']."</a><span class='commentDate'>".$commentDatetime."</span><div class='clear'></div>"."<div class='comments'>".$row['content']."</div>"."</p>";
			
		}

			if($_SESSION['user_id'] != '' && $row['user_id'] == $_SESSION['user_id'] && $row['user_type'] == $_SESSION['user_type'])
			{
				echo "<img class='delete_Comment' onClick=\"delete_comment('".$row['id']."', 'show_cm_".$forun_id."');\" width='16px' height='16px' src='images/del-notification.png' style='float: right; cursor: pointer; border: medium none;'>"; 
			}
			
			echo "</div>"; 
		}
	//}
	}
	
	
?>
