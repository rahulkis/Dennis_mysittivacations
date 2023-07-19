<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$commentID = 0;
$response = ['count' => 0, 'message' => ''];
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
        $commentID = $l_id;
        $find_count = mysql_query("SELECT fc.*,u.first_name,u.last_name,u.image_nm FROM forum_comment as fc left join user as u on(u.id=fc.user_id) where fc.id='".$l_id."' ORDER BY fc.id DESC");
    }

    $find = mysql_query("SELECT fc.*,u.first_name,u.last_name,u.image_nm FROM forum_comment as fc left join user as u on(u.id=fc.user_id) where fc.forum_id='".$forun_id."' ORDER BY fc.id DESC");
    //Setup the un-ordered list
    $count_comments = mysql_num_rows($find);
    $row = mysql_fetch_array($find);
    $commentDatetime = date('F j, g:i a',strtotime($row['added_date']));
    $getdataq = mysql_query("SELECT * FROM `clubs` WHERE `id` = '".$row['user_id']."' ");
    $fetchdataq = mysql_fetch_array($getdataq);
    $img="";
    if($fetchdataq['image_nm']!="")
    {
     $img=$fetchdataq['image_nm'];
    }
    else
    {
      $img="images/pic1.jpg";
    }
    $username = "";
    if($row['user_type'] == "user"){
    
      $username = $fetchdataq['first_name']." ".$fetchdataq['last_name'];    
  
     }elseif($row['user_type'] == "club"){

      $username = $fetchdataq['first_name']." ".$fetchdataq['last_name'];  
    } 
    $message = $emojione->shortnameToImage($content);

    $html = '<div class="box3 box3_hide_rep onload_comments hide_replies_'.$forun_id.' comment_box c_box_'.$row['id'].' jquery_loaded_comments_'.$forun_id.'" style="display: block;">      
    <div class="commentator">
    <a href="host_profile.php?host_id='.$row['user_id'].'"><img height="40" src="'.$SiteURL.$img.'" width="40"> </a>
    </div>
    <div class="commentator_info"><a class="commentuser" href="host_profile.php?host_id='.$row['user_id'].'">'.$fetchdataq['club_name'].'</a><span class="commentDate">'.$commentDatetime.'</span><div class="clear"></div>'.$message.'</div>';
    if($_SESSION['user_id'] != '' && $row['user_id'] == $_SESSION['user_id'] && $row['user_type'] == $_SESSION['user_type'])
          {
    $html .= "<img class='delete_Comment' onClick=\"delete_comment('".$commentID."', 'show_cm_".$forun_id."');\" width='16px' height='16px' src='images/del-notification.png' style='float: right; cursor: pointer; border: medium none;'>";
    }
    $html .= "</div>";

        $response['count'] = $count_comments;
        $response['message'] = $html;
    }
    echo json_encode($response);
    
?>
