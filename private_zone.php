<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

	
$para="";
if(isset($_REQUEST['msg']))
{
$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="admin_app")
	{
	$message="Your Forum Posted Sucessfully";
	}
}
$userID=$_SESSION['user_id'];
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;

	if(isset($_GET['id'])){
	 $UserID=$_GET['id']; 
	}
	else {
	$UserID=$_SESSION['user_id'];	
	}
	$sql1 = "select * from `user` where `id` = '".$UserID."'";
	$userArray1 = $Obj->select($sql1) ; 
	$first_name=$userArray1[0]['first_name']; 
	$last_name=$userArray1[0]['last_name'];
	//$profilename = 
	$zipcode=$userArray1[0]['zipcode'];
	$state=$userArray1[0]['state'];
	$country=$userArray1[0]['country'];
	if($userArray1[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray1[0]['DOB'];
	$city=$userArray1[0]['city'];
	$email=$userArray1[0]['email'];
	$image_nm=$userArray1[0]['image_nm'];
	$phone=$userArray1[0]['phone'];
	/**********************************/
    $profile_name=$userArray1[0]['profilename'];
 $titleofpage="Clique";   
include('header_start.php');
require_once("admin/paging.php");
?>

<!--<link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="0Wa2APQD611bHQYCSnLVv38OaClLmvckYp6C";</script>-->
<script src="js/private-zone.js"></script>

<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>

<link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<style>
#middle{
	min-height:500px;
	width:693px;
	
	}
	
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
	width:600px;
} 

.show_all_comments .box3{
	color: rgb(254, 205, 7);
	text-decoration: underline;
}

.onload_comments{
	display: none;
}

.hide_cm{
	display: none;
}
</style>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45982925-1', 'mysitti.com');
  ga('send', 'pageview');
  

</script>

<?php include('header.php'); ?>
<script src='js/jqueryvalidationforsignup.js'></script>
<script src="js/register.js"></script>
<?php
if($_POST['update']){
	
	if($_FILES['forum_img']['error'] == "0"){
		
				$file_type = $_FILES['forum_img']['type'];
				$exp_file_type = explode('/', $file_type);
				$check_file_type = $exp_file_type[0];
				
				if($check_file_type == "video" || $check_file_type == "application"){
					
					$forum_video=$_FILES['forum_img']['name']; 
					$tmp = $_FILES["forum_img"]["tmp_name"]; 
					$video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 
					move_uploaded_file($tmp,$video_name);
					
				}elseif($check_file_type == "image"){
					
					$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
					$temp = explode(".", $_FILES["forum_img"]["name"]);
					$extension = end($temp);
					$name = $_FILES["forum_img"]["name"];
					$ext =substr($name,strrpos($name,'.'));
					$tmp1 = $_FILES["forum_img"]["tmp_name"];
					$path = "upload/forum_".time().strtotime(date("Y-m-d")).$name;
					$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$name."_thumbnail".$ext;
					$thumbnail = "upload/".$thumb;
					move_uploaded_file($tmp1,$path);
					
					
						 //indicate which file to resize (can be any type jpg/png/gif/etc...)
						$file = $path;
						
						//indicate the path and name for the new resized file
						$resizedFile = $thumbnail;
						
						//call the function (when passing path to pic)
						smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
						//call the function (when passing pic as string)
						smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );
				}
				
							$forum=mysql_escape_string($_POST['forum']);
							$forum_img=$thumbnail;
							$forum_video=$video_name;
							$user_id=$_SESSION['user_id'];
							$added_on=date("Y-m-d h:i:s");
							$status=1;
							//$forum_city=
							$ThisPageTable='forum';
							//$ValueArray = array('profile',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$user_id,$added_on,$city_id,'public',$status);
							//$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status');
							//$Success = $Obj->Update_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray,'forum_id',$_POST['forum_id']);
								
								
								$forum = mysql_escape_string($_POST['forum']);
								$added_on = date("Y-m-d");
								
								mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."', forum_img = '".$path."', image_thumb = '".$forum_img."', forum_video = '".$forum_video."' WHERE common_identifier = '".$_POST['common_identifier']."' AND user_id != '0' AND forum_id = '".$_POST['forum_id']."'");
								
								$_SESSION['post_edit_success'] = "updated";				
		
		}else{
		
		$forum = mysql_escape_string($_POST['forum']);
		$added_on=date("Y-m-d");
		
		mysql_query("UPDATE forum SET forum = '".$forum."', added_on = '".$added_on."' WHERE common_identifier = '".$_POST['common_identifier']."' AND user_id != '0' AND forum_id = '".$_POST['forum_id']."'");
		$_SESSION['post_edit_success'] = "updated";
		
	}
	
}


if($_POST['submit'])
{
	
		$file_type = $_FILES['forum_img']['type'];
		$exp_file_type = explode('/', $file_type);
		$check_file_type = $exp_file_type[0];
		
		if($check_file_type == "video" || $check_file_type == "application"){
			
				$forum_video=$_FILES['forum_img']['name'];
				$tmp = $_FILES["forum_img"]["tmp_name"]; 
				$video_name = "video/forum_".time().strtotime(date("Y-m-d")).$forum_video; 			
			
			}elseif($check_file_type == "image"){
			
				$allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","GIF");
		        $temp = explode(".", $_FILES["forum_img"]["name"]);
		        $extension = end($temp);
				$name = $_FILES["forum_img"]["name"];
				$ext =substr($name,strrpos($name,'.'));
				$tmp1 = $_FILES["forum_img"]["tmp_name"];
				$path = "upload/forum_".time().strtotime(date("Y-m-d")).$name;
				$thumb = "_".time().md5(strtotime(date("Y-m-d"))).$name."_thumbnail".$ext;
				$thumbnail = "upload/".$thumb;
				move_uploaded_file($tmp1,$path);
				
				//indicate which file to resize (can be any type jpg/png/gif/etc...)
			   $file = $path;
			   
			   //indicate the path and name for the new resized file
			   $resizedFile = $thumbnail;
			   
			   //call the function (when passing path to pic)
			   smart_resize_image($file , null, 324 , 200 , false , $resizedFile , false , false ,100 );
			   //call the function (when passing pic as string)
			   smart_resize_image(null , file_get_contents($file), 324 , 200 , false , $resizedFile , false , false ,100 );
		}
	
		$forum=mysql_escape_string($_POST['forum']);
		$forum_img=$thumbnail;
		$forum_video=$video_name;
		$user_id=$_SESSION['user_id'];
		$added_on=date("Y-m-d h:i:s");
		$status=1;
		//$forum_city=
		$ThisPageTable='forum';
		$common_identifier = date("Ymdhis");
		
		if($_POST['post_type']=='private'){
			
			
			
      		$city = $_SESSION['id'];
      		$getfriendsquery = @mysql_query("SELECT `f`.`friend_id` FROM `friends` as f  WHERE `f`.`user_id` = '".$_SESSION['user_id']."'  AND `f`.`friend_type` = 'user' AND `f`.`friend_id` != '".$_SESSION['user_id']."'  AND `f`.`status` = 'active' AND close_friend = '1'");
      		$countrows = @mysql_num_rows($getfriendsquery);
      		$ValueArray = array($_SESSION['user_id'],'clique',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$user_id,$added_on,"",'private',$status,$uid, $common_identifier);
				
		$FieldArray = array('from_user','post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id', 'common_identifier');

	    	$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
			
		$inserted_event_id = mysql_insert_id();
      		if($countrows > 0)
      		{

      			while($result = @mysql_fetch_array($getfriendsquery))
      			{
      			$uid = $result['friend_id'];
					
				
				
				$post_added_on = date('Y-m-d h:i:s');
				$c_identifier = "forum_".$inserted_event_id;
		
				mysql_query("INSERT INTO user_notification (`from_user`, `to_user`, `type`, `added_on`, `status`, `common_identifier`, `from_user_type`, `to_user_type`)VALUES('".$_SESSION['user_id']."', '".$uid."', 'clique', '".$post_added_on."', '1', '".$c_identifier."', 'user', 'user')");					
					
					
      			}

      		}			
			
			
		//	
		//	
		//$_POST['friendsdropdownselected'] =	implode(", ", $_POST['friendsdropdownselected']);
		//$_POST['groupdropdownselected'] = implode(", ", $_POST['groupdropdownselected']);
		//
		//print_r($_POST['friendsdropdownselected']);
		//print_r($_POST['groupdropdownselected']);
		//die;
		//
		//
		//$ValueArray = array('clique',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$user_id,$added_on,"",$_POST['post_type'],$status,$_POST['friendsdropdownselected'],$_POST['groupdropdownselected'], $common_identifier);
		//$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id', 'common_identifier');
		
  }else{
  		$city = $_SESSION['usercity'];
	 	$ValueArray = array('clique',$_SESSION['user_type'],$forum_img,$forum,$path,$forum_video,$user_id,$added_on,$city,$_POST['post_type'],$status,"","", $common_identifier);
		$FieldArray = array('post_from','user_type','image_thumb','forum','forum_img','forum_video','user_id','added_on','city_id','forum_type','status','friends_id','group_id', 'common_identifier');
   		$Success = $Obj->Insert_Dynamic_Query($ThisPageTable,$ValueArray,$FieldArray);
  }
		
		move_uploaded_file($tmp,$video_name);
			if($Success > 0)
			{
				if($_POST['action']=="/upload_video.php")
				{
					header('location: upload_video.php');exit;
				}
				elseif ($_POST['action'] == "/upload_photo.php") {
					# code...
					header('location: upload_photo.php');exit;
				}
				else
				{
					if($_POST['post_type']=='private')
					{
						$_SESSION['popup_add_post'] = "added";
					}
					
				}

			}
						
		$_SESSION['popup_add_post'] = "added";
}
?>
<script type="text/javascript">

function assignFriends(uid)
{
	$('div#showFriends').slideToggle('slow');
}

function makeclosefriend(makeclosefriendID1)
{
	//var makeclosefriendID1 = $(this).attr('id');
	//alert(makeclosefriendID1);
	var makeclosefriendID = makeclosefriendID1.split('_');
	makeclosefriendID = makeclosefriendID[1];
	//alert(makeclosefriendID);
	if($('#'+makeclosefriendID1).is(':checked'))
	{

		$.ajax({
		type: "POST",
		url: "all_friends.php",
		data: "makeclosefriendID="+makeclosefriendID+"&statustext="+1,

		success: function(result){
			alert("Added as close friend");
		}
		});
	}
	else
	{
		$.ajax({
		type: "POST",
		url: "all_friends.php",
		data: "makeclosefriendID="+makeclosefriendID+"&statustext="+0,

		success: function(result){
			alert("Removed from close friend list");
		}
		});

	}	
	//location.reload(true);
}



</script>
<style type="text/css">

#title .title {
	float: left;
	width: 80%;
}

</style>

<div class="home_wrapper">
  <div class="main_home">
   <div class="home_content">
 <div class="home_content_bottom">		

<div id="title" class="botmbordr">
<?php
echo "<h1 class='title' >";

if($_GET['id']){
    $sql1 = "select first_name, last_name,profilename  from `user` where `id` = '".$_GET['id']."'";
	$userArrayname = $Obj->select($sql1) ; 
	$profilename = $userArrayname[0]['profilename']; 
	if($profilename == "")
	{
		echo $first_name=$userArrayname[0]['first_name']; 
		echo  "  ";	
		echo $last_name=$userArrayname[0]['last_name'];
	}
	else
	{
		echo $profilename;
	}
  
}else{
	if($profile_name == "")
	{
		echo $first_name." ".$last_name; ?> Clique
<?php 	}else{ 	echo $profile_name." Clique";} }?>
</h1>
<?php if(!isset($_GET['id'])){ ?>

<!--<a  style=" float: right;font-size: 14px;font-weight: normal;" href="my_private_post.php" class="button">Manage Posts</a>-->
<a href="javascript:void(0);" style="color:#fecd07;float:right;font-size:13px;" onclick="assignFriends('<?php echo $_SESSION[user_id]?>');" id="assignFriends">Add Friends to Clique</a>

<?php } ?>

     		 <? if(isset($_SESSION['popup_add_post'])){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Clique Post Successfully Added</div> 
				  
			  <?  unset($_SESSION['popup_add_post']); }?>
			  
     		 <? if(isset($_SESSION['post_edit_success']) == "updated"){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Post Updated Successfully </div> 
				  
			  <?  unset($_SESSION['post_edit_success']); }?>
			  
			  			  
     		 <? if(isset($_SESSION['p_post_del']) == "success"){?>
				  <div id="successmessage" style="margin-bottom:6px;"> Post Deleted Successfully </div> 
				  
			  <?  unset($_SESSION['p_post_del']); }?>			  
</div>  
  
      
			<?php if(!isset($_GET['id'])) { ?>
			
			<?php /*?> <div id="submit_btn " style="float:left; color:red; text-align: center; width: 100%; padding:0 0 15px 0;"><?php */?>
			<!--<a style="font-size: 14px; float:right;"  id="modal_trigger23" href="#" onclick="javascript:void window.open('add_private_post_clique.php','','width=500,height=700,resizable=true,left=0,top=0');return false;" class="button addpost">Add Post</a>-->
			<?php /*?>    </div><?php */?>
			
			<?php }
			
			if($message!=""){ ?>
			
				<div id="msg" style="background-color:#FFCCFF; color:#008000"><?php echo $message; ?> </div>
			
			<?php } ?>

			<div id="showFriends" style="display: none;">
				<?php 
					if(isset($_POST['makeclosefriendID']))
					{
						$userID=$_SESSION['user_id'];
						$userType= $_SESSION['user_type'];
						$makeclosefriendID=$_POST['makeclosefriendID'];
						$statustext=$_POST['statustext'];

						echo $update_sqltext="update friends set close_friend='".$statustext."' where user_id='".$userID."' and friend_id='".$makeclosefriendID."'";
						$sqldatetext=mysql_query($update_sqltext);die;

					}

					$sql4="select DISTINCT(u.id),u.first_name,u.is_online,u.last_name,u.image_nm,cc.city_name,z.name as state ,z.code,c.name as country,f.status,f.id as f_id ,f.close_friend as close_friend from  friends as f 
						left join user as u on(f.friend_id=u.id)
						left join capital_city as cc on(cc.city_id=u.city)
						left join  zone as z on(cc.state_id=z.zone_id)
						left join country as c on(c.country_id=z.country_id)
						where f.status IN ('active')
						AND u.first_name != 'NULL' 
						AND f.user_id='".$_SESSION['user_id']."'
						AND f.user_type = 'user'
						AND f.friend_type = 'user'
						GROUP BY id ";
					$sql6=@mysql_query($sql4);
					$num=@mysql_num_rows($sql6);
					while($sql5=@mysql_fetch_array($sql6))
					{
						$username = $sql5['first_name']."-".$sql5['last_name'] ;

					?>
						<div class="infodiv">
							<div style="float:left; margin: 0 20px 0 0;">
								<?php
									if($sql5['image_nm']!="")
									{
								?>
										<img src="<?php echo $sql5['image_nm']; ?>" height="100" width="100" style="border:1px solid #cccccc;" />
								<?php 	} 
									else 
									{ 
								?>
										<img src="images/man4.jpg"  height="100" width="100" style="border:1px solid #cccccc;"/>
								<?php } ?>	
							</div>
							<div class="info_zone">
							<?php
								echo $sql5['first_name'] ." ". $sql5['last_name'] ."<br/>". $sql5['country'] ."<br/>".  $sql5['state'] . "<br/>". $sql5['city_name'] . "<br/>";
							?>
								<div class="makeclosefriend">
									<input id="makeclosefriend_<?php echo $sql5['id']; ?>" type="checkbox" <? if($sql5['close_friend']){ echo "checked";} ?> value="<?php echo $sql5['id']; ?>" onclick="makeclosefriend('makeclosefriend_<?php echo $sql5[id]; ?>');" class="makeclosefriend" name="makeclosefriend">
									Clique
								</div>
							</div>
						</div>
					<?php
					}
				?>
			</div>




			
	<?php if(!isset($_GET['id'])){ ?>		
    <div id="ad_profile_pst">
            <form id="post_cm_form" name="forum" action="" method="post" onsubmit="return validate_forum();" enctype="multipart/form-data">
			<div class="ppost_newdesign">
                <div class="lbl">  
                    <label>What&#39;s happening ?</label>
                    <div id="u_0_s" class="_6a _m">
 	                	
                    <a id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb">
                    <span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf">
					<img src="images/upload_camera.png">
                    </i>Add Photo/Video<i class="_2wr"></i>
                    </span>
                    
                    <div class="_3jk">
                    <input type="file" aria-label="Upload Photos/Video" name="forum_img" title="Choose a file to upload" class="_n _5f0v" id="js_0" onChange="return ValidateFileUpload()">
						<span style="display: none;" id="file_upload_successs"><img src="images/tick_green_small.png"></span>
                    </div>
                    </a>
       
				</div>
                    <textarea id="add_post_text" required name="forum" class="txt_box clear_flds ad_c_post" /></textarea>
                </div>
                
               <div>
               					<input type="hidden" name="post_type" value="private" />
					<input id="submit3" type="submit" name="submit" value="Post" class="button" style=""  />

               
               </div>
               
            </div>

			<!--<ul class="btncenter_new" style="float: right;">
				<li>
				</li>
				<li>
					<input type="hidden" name="post_type" value="private" />
					<input id="submit3" type="submit" name="submit" value="Post" class="button" style=""  />
				</li>
			</ul>-->
           </form>		
	</div>				
	<?php } ?>		
			

       <div id="middle" style="width:700px;"  >
         <?php 
				
			 	if(isset($_REQUEST['id']))
			 	{
				  	$userID=$_REQUEST['id'];
			  	}
			  	else 
			  	{
				  	$userID=$_SESSION['user_id']; 
			  	}
		  // 
		  // $sql = @mysql_query("select forum.forum_id, forum.forum,forum.forum_img,forum.forum_video,forum.status,user.first_name,user.last_name,user.image_nm from forum 
		  // LEFT JOIN user ON forum.user_id= user.id 
		  // where forum.status ='1' AND forum.user_id=".$UserID."  AND forum_type!='regular'
		  //  OR (forum.forum_id IN(select fm.forum_id from friends as f left join forum as fm on(f.friend_id=fm.user_id) where f.user_id=".$UserID." AND fm.forum_type='public')) order by forum_id DESC");
         	$sql = "SELECT * FROM `forum` as f, `user` as u WHERE f.user_id = '$userID' AND f.user_id = u.id AND f.forum_type = 'private' AND f.status = '1' AND f.post_from = 'clique'  ORDER BY forum_id DESC";
		 
    	$sql1 = @mysql_query($sql);
    	$count = @mysql_num_rows($sql1);		 

    $rowCount = 0;
    $total = 0;
    $total = $count;
    if(isset($_GET['page']))
    {
                $page = $_GET['page'];
            }
            else
            {
        $page = '1';
            }
            $limit = '10';  //limit
    $i=$limit*($page-1);
    
    $pager = Pager::getPagerData($total, $limit, $page);
    $offset = $pager->offset;
    $limit  = $pager->limit;
    $page   = $pager->page;
    $sql = $sql . " limit $offset, $limit";



if($count > 0)
{
	$sql = @mysql_query($sql);
	$iiii = 1;
while($row = @mysql_fetch_array($sql))
	{
		// echo "<pre>";
	 //   print_r($row);exit;
	   ?>
        <div class="post blog1"> 
        	

            <a href="#" class="pic">
                <?php
          		        if($row['image_nm']==""){ ?>
                        <img src="images/man1.jpg" />
                <?php 
          		        }else{ $imagesrc = $row['image_nm'];
                ?>
          		          <img src="<?php echo $imagesrc; ?>" />
          		          <?php
          		          	if($row['profilename'] == '')
          		          	{
          		           	echo $row['first_name']." ".$row['last_name']; 
      		        	}
      		        	else
      		        	{
      		        		echo $row['profilename'];
      		        	}
          		          ?>
                <?php } ?>
                
            </a>
            <div class="sub_post blog_content">
                
                
                   

                <div class="content" id="forumcontent">
                	<div class="forumName">
                	<h1 id="cntrls">
					<div><?php echo $row['forum']; ?> </div>	
					<?php/*
					
					if(isset($_GET['id'])){}else{
					?>
                        <div class="manage_current_p_post" style="float: left; background: none; width: 10%;">
                        <a onClick="edit_post('<?php echo $row["forum_id"]; ?>');" href="javascript:void(0);"><img width="25px" height="25px" ;="" src="images/edit_white.png"></a>
                        <a onClick="delete_post('<?php echo $row["common_identifier"]; ?>');" href="javascript:void(0);"><img width="25px" height="25px" ;="" src="images/del_white.png"></a>
                        </div>
                    <?php } */?>   						
						
						
					</h1>
			<?php
					
					//if(isset($_GET['id'])){}else{
					//if($row['from_user'] == $_SESSION['user_id']){ ?>
        <!-- edit controls -->
        <div class="manage_current_p_post manage">
                        <a class="edit_post_pro" title="Edit" onClick="edit_post('<?php echo $row["forum_id"]; ?>');" href="javascript:void(0);"><img src="images/edti_post1.png"></a>
                        <a  class="del_post_pro"  title="Delete" onClick="delete_post('<?php echo $row["common_identifier"]; ?>');" href="javascript:void(0);"><img src="images/del_post.png"></a>
                        </div>
                     <!-- /edit controls -->    
                         <?php //}} ?>
                 </div>
                	<?php $share_img=''; if($row["forum_img"]!="") {

                            $explode = explode('../',$row["forum_img"]);
                            $explode1 = explode('../',$row["image_thumb"]);
                            if(!empty($explode[1]) )
                            {
                                $adv_img1= substr($row["forum_img"],3);   
                            }
                            else
                            {
                                $adv_img1= $row["forum_img"];
                            }
                            if(!empty($explode1[1]) )
                            {
                                $adv_img12= substr($row["image_thumb"],3);   
                            }
                            else
                            {
                                $adv_img12= $row["image_thumb"];
                            }
$share_img=$row["forum_img"];
                        ?>
                    <a href="<?php echo $row['forum_img']; ?>" rel="lightbox"><img src="<?php echo $adv_img12; ?>" alt="" /></a>
                    <?php   } ?>
                    <?php if($row["forum_video"]!="") { ?>
                        <a href="#dialogx" name="modal">
                        <div id="a<?php echo $row["forum_id"];?>"></div>
                            <script type="text/javascript">
                             jwplayer("a<?php echo $row["forum_id"];?>").setup({
                                file: "<?php echo $row["forum_video"];?>",
                                height : 140 ,
                                width: 200
                                });
                            </script>
                        </a>
                    <?php $share_img=$row["forum_video"]; } ?>
                </div>
                <div class="comment_box commentdisplay">
                    <div class="box">
                        <div class="comment1">
                            <?php
        	                    $sql_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."'");
                                $like_tot= @mysql_num_rows($sql_like);
         
                                $sql_usr_like= @mysql_query( "SELECT `like_user_id` FROM `forum_like` WHERE `forum_id` = '".$row["forum_id"]."' AND like_user_id='".$_SESSION['user_id']."'");
                                $is_like= @mysql_num_rows($sql_usr_like);
                    		?>
                                <p id="report_error_<?php echo $row["forum_id"];?>" style="color:red; font-size:14px;"></p>
                                <p id="report_send_<?php echo $row["forum_id"];?>" style="color:green font-size:14px;" ></p>
                        <?php if($_SESSION['user_id']!="") {?>    
                                <span id="glike_<?php echo $row["forum_id"];?>">
                                	<?php if($is_like <= 0) { ?>
                                <a href="javascript:void(0);"   onclick="newflike('<?php echo $row["forum_id"];?>');">Shout</a>
                                <?php }else{ echo "Shout "; } ?> | </span>
                                <a href="javascript:void(0);" onclick="javascript:document.getElementById('content_<?php echo $row["forum_id"];?>').focus();">Comment</a> |
                                <a href="javascript:void(0);" onclick="reportabuse('<?php echo $row["forum_id"];?>');">Report Abuse</a> 
                        <?php } ?>
                        </div>
                    </div>
                    <div class="box2">
                        <div class="like">
                            <!-- <a href="javascript:void(0);"  <?php //if($is_like <= 0) { ?> onclick="flike('<?php //echo $row["forum_id"];?>');" <?php //} ?>>
                                <img src="images/like.jpg" />
                            </a> -->
                            <span id="like_<?php echo $row["forum_id"];?>">
                                <?php echo "Shouts ".$like_tot ?>
                            </span>
                        </div>
                        <div class="icons">
 <a rel="nofollow" href="javascript:void(0);" class="fb_share_button" onclick="return fbs_click('https://www.mysitti.com/<?php echo $share_img;?>', 'mysitti.com' )" target="_blank" style="text-decoration:none;"><img src="fbook.png" alt="Share on Facebook"/></a>	
					
					<a href="#" onclick="return fbs_click123('https://www.mysitti.com/<?php echo $share_img;?>')" target="_blank" style="text-decoration:none;" title="Click to share this post on Twitter"><img src="twt.png" alt="Share on Twitter"/></a>				
					
					<a href="https://plus.google.com/share?url=https://www.mysitti.com/<?php echo $share_img;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="g+.png" alt="Share on Google+"/></a>
                   
                        </div>
                    </div>
                    <div class="" id="comment_all_<?php echo $row["forum_id"];?>">
                        <?php
                            $find = mysql_query("SELECT * FROM forum_comment where forum_id='".$row["forum_id"]."' ORDER BY id ASC");
							
									$count_comments = mysql_num_rows($find);
									?>
									<input type="hidden" id="num_comments_<?php echo $row['forum_id'];?>" value="<?php echo $count_comments; ?>" />
									<input type="hidden" id="set_show_val_<?php echo $row['forum_id']; ?>" value="0">
									<div class="box3 show_all_comments" id="show_count_comments_<?php echo $row["forum_id"]; ?>">
									
										<div class="box3">
											<div onclick="show_all_comments('<?php echo $row['forum_id']; ?>');" id="show_cm_<?php echo $row['forum_id']; ?>">Show comments : <?php echo $count_comments; ?></div>
											<div class="hide_cm" onclick="hide_all_comments('<?php echo $row['forum_id']; ?>');" id="hide_cm_<?php echo $row['forum_id']; ?>">Hide all comments</div>
											
										</div>
		
							
									</div>	
				
							
                            <?php
							$row_i = 0;
							while($row2 = @mysql_fetch_array($find)){
								
								
								if($row_i == 0){ ?>
								
                                <div class="box3 hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>">
                                    <!-- <div class="pic1"> -->
									<?php
									if($row2['user_type'] == 'club')
									{
										$getuser = @mysql_query("SELECT club_name, image_nm FROM `clubs` WHERE id='".$row2['user_id']."'");
									}
									else
									{
										$getuser = @mysql_query("SELECT first_name,last_name,profilename, image_nm FROM `user` WHERE id='".$row2['user_id']."'");
									}
									
									$getdet = @mysql_fetch_assoc($getuser);
									
									?>
									
									
                                        <?php if($getdet['image_nm']=="") { ?> 
                                                <img src="images/pic1.jpg" />
                                        <?php }else{ ?>
                                                <img width='40' height='40' src="<?php echo $getdet['image_nm']; ?>"  />
                                        <?php } ?>
                                    <!-- </div> -->
                                <p>
                                    <?php 
                                        if($_SESSION['user_id'] != '')
                                        {
                                    ?>
                                        <!-- <img onclick="delete_comment('<?php echo $row2['id']; ?>');" width="16px" height="16px" src="images/del.png" style="float: right; cursor: pointer;"> -->
                                    <?php 

                                        }
                                    ?>
									
									<?php 
										if($row2['user_type'] == 'club')
										{
											?>
											
											 <a class="commentuser"><?php echo $getdet['club_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
										else
										{
											?>
											 <a class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
									?>
									
                                   
                                    
                                    <!-- <div class="comment_txt">
                                        <?php //echo $row2['content'];?>
                                    </div> -->
                                </div>								
								
								<?php }else{ ?>
								
                                <div class="box3 onload_comments hide_replies_<?php echo $row["forum_id"]; ?> comment_box c_box_<?php echo $row2['id']; ?>">
                                    <!-- <div class="pic1"> -->
									<?php
									if($row2['user_type'] == 'club')
									{
										$getuser = @mysql_query("SELECT club_name, image_nm FROM `clubs` WHERE id='".$row2['user_id']."'");
									}
									else
									{
										$getuser = @mysql_query("SELECT first_name,last_name,profilename, image_nm FROM `user` WHERE id='".$row2['user_id']."'");
									}
									
									$getdet = @mysql_fetch_assoc($getuser);
									
									?>
									
									
                                        <?php if($getdet['image_nm']=="") { ?> 
                                                <img src="images/pic1.jpg" />
                                        <?php }else{ ?>
                                                <img width='40' height='40' src="<?php echo $getdet['image_nm']; ?>"  />
                                        <?php } ?>
                                    <!-- </div> -->
                                <p>
                                    <?php 
                                        if($_SESSION['user_id'] != '')
                                        {
                                    ?>
                                        <!-- <img onclick="delete_comment('<?php echo $row2['id']; ?>');" width="16px" height="16px" src="images/del.png" style="float: right; cursor: pointer;"> -->
                                    <?php 

                                        }
                                    ?>
									
									<?php 
										if($row2['user_type'] == 'club')
										{
											?>
											
											 <a class="commentuser"><?php echo $getdet['club_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
										else
										{
											?>
											 <a class="commentuser"><?php echo $getdet['first_name']; ?> <?php echo $getdet['last_name']; ?></a><br ><?php echo $row2['content']; ?></p>
											
											<?php 
										}
									?>
									
                                   
                                    
                                    <!-- <div class="comment_txt">
                                        <?php //echo $row2['content'];?>
                                    </div> -->
                                </div>								
								
								<?php } ?>
								
                        <?php $row_i++; } ?>
                    </div>
                    <?php if($_SESSION['user_id']!=""){ ?>
                    <div class="box3">
                        <input type="hidden" id="fid_<?php echo $row["forum_id"];?>" value="<?php echo $row["forum_id"];?>">
                        <div class="comment_txt">
                            <input name="comment"  onkeydown="javascript:return submitcom(event,'<?php echo $row["forum_id"];?>');"   id="content_<?php echo $row["forum_id"];?>" type="text" placeholder="Write a comment.." value=""/> 
                        </div>
                        <div align='center'>
                            <input name="button" class="button" id="co_submit_<?php echo $row["forum_id"];?>"  onclick="addform('<?php echo $row["forum_id"];?>');" type="button" value="Add Comment" />
							<img id="comment_load_<?php echo $row["forum_id"]; ?>" src="images/loading-plz.gif" style="margin: -19px 0px 0px 10px; display: none;">                       </div>
                        <div id="comsuc_<?php echo $row["forum_id"];?>" style="float:right; color:green; display:none;"></div>
                        <div id="com_error<?php echo $row["forum_id"];?>" style="float:left; color:red; display:none;"></div>
                    </div>
					
					<?php } ?>
                </div>
            </div>
        </div>
        <hr>
<?php 

    }
	
echo '<div class="pagination">';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1"><span title="First">&laquo;</span></a>';
		if ($page <= 1)
			echo "<span>Previous</span>";
		else            
			//echo "<a href='".$_SERVER['PHP_SELF']."'?page=".($page-1)."'><span>Previous</span></a>";
			echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page-1)."'><span>Previous</span></a>";
		echo "  ";
		for ($x=1;$x<=$pager->numPages;$x++){
			echo "  ";
			if ($x == $pager->page)
				echo "<span class='active'>$x</span>";
			else
				echo "<a href='".$_SERVER['PHP_SELF']."?page=".$x."'><span>".$x."</span></a>";
		}
		if($page == $pager->numPages) 
			echo "<span>Next</span>";
		else           
			echo "<a href='".$_SERVER['PHP_SELF']."?page=".($page+1)."'><span>Next</span></a>";
								
		echo "<a href='".$_SERVER['PHP_SELF']."?page=".$pager->numPages."'><span title='Last'>&raquo;</span></a>";
echo "</div>";	

}
else
{
     echo "<p id='errormessage' style='display:block;'>No Posts Yet.</p>";
}
?>
         
	 </div>
	
        </div>
    </div>
    <?php /*
         <aside class="sidebar">
	              <?php 

      		if(!isset($_GET['id']))
      		{ 
		?>
			<div class="user-profle">
     
				<?php
				if(isset($_SESSION['img']) && $_SESSION['img']!='')
				{?>
		        	<img src="<?php echo $_SESSION['img']; ?>" >
				<div class="uname"><?php echo $_SESSION['username'];?></div>
				
		        <?php 
				}
				
				?>
            </div> 


		<?php 
      		}
      		else
			{
				//die('dfd');
			}

      	?>
       <div class="profileleft">
					<?php   */
                    if(!isset($_REQUEST['id'])){?>
                               <!-- <div class="side_profile">     -->
            
                            <?php include('friend-right-panel.php'); ?>
	    <!-- </ul>
                       		</div> -->
                     <? }else {  ?>
                                                   
                            <?php include('friend-profile-panel.php'); ?>
			    	    
                       <?php } ?>
                
    </div>
    </div>
    <?php include('footer.php'); /* ?>
</div>

<style>
.popupContainer{
	 top: 47px !important;
}

</style>
<script type="text/javascript" src="js/chat.js"></script>

	<div id="modal" class="popupContainer" style="display:none; width:498px; margin-top:38px;top:84px!important;">
		
			<div class="header_title popheaderzx" style="border-bottom: 1px solid #808080;
  color: #FECD07;
  font-size: 21px;
  padding-bottom: 20px;
  padding-left: 12px;
  padding-top: 26px;cursor:pointer;
">Add Private Post</div>
			<span style="font-size: 31px;
    position: absolute;
    right: -5px;
    top: -11px;"class="modal_close clszxc">X</span>
		
		
		<section class="popupBody postpopupz">
			
			<div class="user_register">
			<?php include_once("add_private_post_clique.php"); ?>	
			</div>
		</section>
	</div>
</body>
</html>
<script type="text/javascript">
function validate_forum()
{
	if( document.forum.forum.value== "" )
   {
		alert( "Please provide forum data!" );
     	document.forum.forum.focus() ;
     	return false;   
	}


}

function Validate_a_FileUpload(){
		var check_image_ext = $('#a_private_photo').val().split('.').pop().toLowerCase();
		if($.inArray(check_image_ext, ['gif','png','jpg','jpeg','mov','m2ts','mp4','f4v','flv','webm','m4v','wmv','mpg','avi','MPEG','3gp','MPEG-4','3g2','3gpp','3gp']) == -1) {
			alert('Post Image only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, AVI, MP4, WEBM, F4V, M4V and FLV');
			$('#a_private_photo').val('');
		}
}
	
	$("#modal_trigger").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });
	$("#modal_trigger2").leanModal({top : 200, overlay : 0.6, closeButton: ".modal_close" });

	$(function(){
		// Calling Login Form
		$("#login_form").click(function(){
			$(".social_login").hide();
			$(".user_login").show();
			return false;
		});

		// Calling Register Form
		$("#register_form").click(function(){
			$(".social_login").hide();
			$(".user_register").show();
			$(".header_title").text('Register');
			return false;
		});

		// Going back to Social Forms
		$(".back_btn").click(function(){
			$(".user_login").hide();
			$(".user_register").hide();
			$(".social_login").show();
			$(".header_title").text('Login');
			return false;
		});

	});

	function newflike(id)
		{
				//Retrieve the contents of the textarea (the content)
				//Build the URL that we will send
				var url = 'f_id='+id;
				//Use jQuery's ajax function to send it
				 $.ajax({
				   type: "POST",
				   url: "flike.php",
				   data: url,
				   success: function(html){
					$("#like_"+id).html(html);
						$("#glike_"+id).html("Shout |");
					
				   }
				 });
				
				//We return false so when the button is clicked, it doesn't follow the action
				return false;
		}
		
	function delete_comment(id) {
		
			var r = confirm("Are you sure want to delete !");
			if (r == true) {
		
				jQuery.post('ajaxcall.php', {'delete_commment_id':id}, function(response){
					
					if(response == "deleted"){
						$('.c_box_'+id).hide();
					}
					
				});
			}
	}		
</script>

<style>

#lean_overlay{
	opacity: 0.79 !important;
}
.addorremove{
	float: left;
    height: auto;
   
    min-height: 138px;
    min-width: 169px;
    width: auto;
}
.addorremovebutton{
	 float: left;
    height: 100%;
    margin-right: 8px;
    width: 24%
}
</style>

<?php */ ?>

<script type="text/javascript">
	function ValidateFileUpload(){
			var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();
			if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
				alert('Post Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
				$('#js_0').val('');
			}else{
				$('#file_upload_successs').show();
			}
	}
	
	function newflike(id)
		{
				//Retrieve the contents of the textarea (the content)
				//Build the URL that we will send
				var url = 'f_id='+id;
				//Use jQuery's ajax function to send it
				 $.ajax({
				   type: "POST",
				   url: "flike.php",
				   data: url,
				   success: function(html){
					$("#like_"+id).html(html);
						$("#glike_"+id).html("Shout |");
					
				   }
				 });
				
				//We return false so when the button is clicked, it doesn't follow the action
				return false;
		}
		
function validate_forum()
{
	
   var value = $('#add_post_text').val();
   if( $('#add_post_text').val() == "" || $('#add_post_text').val() == " " || value < 1)
   {
		alert( "Please provide post title!" );
     	document.forum.forum.focus();
     	return false;
	}
}

function edit_post(id){
	
	jQuery("html, body").animate({ scrollTop: jQuery("#title").offset().top }, "slow");
	
	jQuery.post('edit_profile_post.php', {'forum_id': id}, function(response){
		
		jQuery("#ad_new_pst").show();
		jQuery("#ad_profile_pst").empty();
		jQuery("#ad_profile_pst").html(response);
		
	});
}

function delete_post(id){
	
    var r = confirm("Are you sure want to delete !");
    if (r == true) {

	 $.get( "deletepost.php?id="+id, function( data ) {
			window.location = "";
		});
	
    }
}
</script>