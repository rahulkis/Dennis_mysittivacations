<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
 $my_smilies = array(
   '@!' => '<img src="group-chat/smilies/barmy.gif"/>',
    '||' => '<img src="group-chat/smilies/bash.gif"/>',
    '&&' => '<img src="group-chat/smilies/bottle.gif"/>',
	 '%#' => '<img src="group-chat/smilies/bike2.gif"/>',
	  '!@' => '<img src="group-chat/smilies/cheer.gif"/>'
    );

error_reporting(0);



$groupInfo = mysql_query("SELECT * FROM `chat_groups` WHERE `create_by` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' ");
$countrecord = mysql_num_rows($groupInfo);

if($_SESSION['user_type'] == "user")
{
	$getUserInfo = mysql_query("SELECT `profilename` FROM `user` WHERE `id` = '$_SESSION[user_id]' ");
	$fetchUserInfo = mysql_fetch_assoc($getUserInfo);
	$groupName = $fetchUserInfo['profilename'];
}
else
{
	$getUserInfo = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$_SESSION[user_id]' ");
	$fetchUserInfo = mysql_fetch_assoc($getUserInfo);
	$groupName = $fetchUserInfo['club_name'];
}

$groupID = $_GET['gID'];



if(isset($_POST['submit']))
{		
	
 	$time=date('Y-m-d H:i:s'); 
	$message=$_POST['message'];
	$sender=$_SESSION['user_id'];
	$group_id = $groupID ;
	mysql_query("INSERT INTO message(message, sender,sent_time,group_id)VALUES('$message', '$sender','$time','$group_id')");
}
	
		$gname=@mysql_query("select * from  chat_groups where id='$groupID' ");
		$group_dtl=@mysql_fetch_assoc($gname);
		
		// check user is avilable in group
		   $chk_user=mysql_query("select  user_id from  chat_users_groups where group_id='$groupID' ");
		   $cnt_row=@mysql_num_rows($chk_user);
		// end here 
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Group Chat</title>
<link rel="stylesheet" type="text/css" href="css/new_portal/style.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/demo.css" />
<link rel="stylesheet" type="text/css" href="slider2/css/custom.css" />
<script language="javascript" src="group-chat/jquery-1.2.6.min.js"></script>
<script language="javascript" src="group-chat/jquery.timers-1.0.0.js"></script>

<style type="text/css">
/* CHAT CSS*/

.refresh {
	border: 1px solid #acd6fe;
	border-left: 4px solid #acd6fe;
	color: green;
	font-family: tahoma;
	font-size: 12px;
	height: 145px;
	overflow-y:auto;
	overflow-x:auto;
	/*width: 365px;*/
	padding:10px;/*background-color:#FFFFFF;*/
}
#title {
	border:0px;
	font-size:30px;
	color:#fff;
	margin-bottom:0px;
}
.grpone {
  background: #fff none repeat scroll 0 0;
  box-sizing: border-box;
  float: left;
  height: 270px;
  min-height: auto !important;
  padding: 10px;
  position: relative;
  width: 100% !important;
}
.ulist {
	border: 1px solid #acd6fe;
	border-left: 4px solid #acd6fe;
	color: green;
	font-family: tahoma;
	font-size: 12px;
	height: 225px;
	overflow: auto;
	width: 92% !important;
	float: left;
	padding:10px;/*background-color:#FFFFFF;*/
}

.ulist p
{
	border-top: none !important;
}

#post_button {
	border: 1px solid #308ce4;
	background-color:#308ce4;
	width: 100px;
	color:#FFFFFF;
	font-weight: bold;
	margin-top: 0px !important;
	margin-bottom: 5px !important;
	padding:5px;
	cursor:pointer;
	border-radius:4px;
}
#textb {
	border: 1px solid #ccc;
	/*width: 283px;*/
	margin:0px 0 10px;
	width: 100%;
	box-sizing:border-box;
	-webkit-box-sizing:border-box;
	border-radius:6px;
	-webkit-border-radius:6px;
	height:35px;
	width:100% !important;
	box-shadow: 0 0 4px #ccc inset;
}
#texta {
	border: 1px solid #000 !important;
	margin-bottom: 10px;
	padding:7px 5px;
}
p {
	border-bottom: 1px dashed #e5e5e5;
	width:100%;
	padding:4px 4px;
	box-sizing:border-box;
	-webkit-box-sizing:border-box;
	border-radius:4px;
	margin-bottom:0px;
	text-align:left;
	max-width:300px;
	text-indent:0px;
	word-wrap:break-word;
}
span {
	font-weight: bold;
	color: rgb(254, 205, 7);
	
}
#sc p span{
 width:100%;
 float:left;
 color:#505050;	
}
.fl {
	float:left
}
#sc{border:0px !important; border-top:1px solid #ccc !important;padding: 2px !important}  
#sc p:hover {background:#f2f2f2;}
#smilies {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	-webkit-box-shadow: #666 0px 2px 3px;
	-moz-box-shadow: #666 0px 2px 3px;
	box-shadow: #666 0px 2px 3px;
	background: #A0CFFB;
	background: -webkit-gradient(linear, 0 0, 0 bottom, from(#A0CFFB), to(#dfeffe));
	background: -webkit-linear-gradient(#A0CFFB, #dfeffe);
	background: -moz-linear-gradient(#A0CFFB, #dfeffe);
	background: -ms-linear-gradient(#A0CFFB, #dfeffe);
	background: -o-linear-gradient(#A0CFFB, #dfeffe);
	background: linear-gradient(#A0CFFB, #dfeffe);
	-pie-background: linear-gradient(#A0CFFB, #dfeffe);
}
.ulist > p {
	float: left;
	width: 100%;
}
.joinbutton {
	float: left;
	margin: 5% 0;
	width: 100%;
}
.groupchatname {
	float: left;
	margin: 10px 0;
	width: 100%;
}
.grp_ceond {
  background: #FFF none repeat scroll 0 0;
  box-sizing: border-box;
  float: right;
  max-height: 290px;
  min-height: 290px;
  overflow: hidden;
  padding: 10px;
  width: 30% !important;
}
.boject_container {width:68%; float:left; margin-right:2%;}
p {
	color: #000 !important;
}
.channel_bg {
	/*background: rgba(0, 0, 0, 0) url("../../images/channel-bg.jpg") no-repeat scroll left top / 100% auto;*/
	float: left;
	width: 100%;
}
.channer_container {
	margin: 20px auto !important;
	width: 860px;
	
}
.channel_inner {
	box-shadow: 0 0 1px rgba(255, 255, 255, 0.3) inset;
	background: rgba(0, 0, 0, 0.3);
	margin-bottom: 30px;
	padding: 10px 10px 20px;
	width:100%;
	float:left;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
}
.webcame_live {
	padding: 10px;
}
object, embed {
 
  max-width: 100%;
}
#sc {
  width: 100%;
  float: l;
  box-sizing: border-box;
  border: 0px !important;
}
.divider {width:100%; height:1px; background:#e7e7e7; float:left; margin:5px 0;}
.closepop {float:right; margin:10px 0;}
#notify_chat {
  background: #f5f5f5 none repeat scroll 0 0;
  border: 1px solid #c0c0c0;
  border-radius: 3px;
  box-shadow: 0 0 24px rgba(0, 0, 0, 0.24);
  box-sizing: border-box;
  display: none;
  left: 0;
  margin: auto;
  max-width: 240px;
  padding: 10px;
  position: absolute;
  right: 0;
  top: 64px;
  width: 100%;
  z-index: 99;
}
#notify_chat a.logon {
  border: 1px solid #CC9B00;
  box-sizing: border-box;
  float: left;
  margin: 10px 0;
  padding: 10px;
  text-align: center;
  width: 100%;
  background: #FECD07;
  color: #000;
  position:relative;
  -webkit-transition:all .9s ease-out;
-moz-transition:all .9s ease-out;
-ms-transition:all .9s ease-out;
-o-transition:all .9s ease-out;
transition:all .9s ease-out;
}
/*
#notify_chat a.logon:before {content:""; position:absolute; left:0; top:0; width:1px; height:0; background:#005e82;-webkit-transition:all .9s ease-out;
-moz-transition:all .9s ease-out;
-ms-transition:all .9s ease-out;
-o-transition:all .9s ease-out;
transition:all .9s ease-out;}
#notify_chat a.logon:hover:before {height:100%;-webkit-transition:all .9s ease-out;
-moz-transition:all .9s ease-out;
-ms-transition:all .9s ease-out;
-o-transition:all .9s ease-out;
transition:all .9s ease-out;}
#notify_chat a.logon:after {content:""; position:absolute; right:0; bottom:0; width:1px; height:0; background:#005e82;-webkit-transition:all .9s ease-out;
-moz-transition:all .9s ease-out;
-ms-transition:all .9s ease-out;
-o-transition:all .9s ease-out;
transition:all .9s ease-out;}
#notify_chat a.logon:hover:after {height:100%;-webkit-transition:all .9s ease-out;
-moz-transition:all .9s ease-out;
-ms-transition:all .9s ease-out;
-o-transition:all .9s ease-out;
transition:all .9s ease-out;}*/
#notify_chat a.logon:hover { background:#1FA7CB; color:#fff; border:1px solid #005e82;-webkit-transition:all .9s ease-out;
-moz-transition:all .9s ease-out;
-ms-transition:all .9s ease-out;
-o-transition:all .9s ease-out;
transition:all .9s ease-out;}
#notify_chat h2 {
  border-bottom: 1px solid #ccc;
  font-size: 15px;
  margin: 10px 0;
  padding-bottom: 10px;
  text-align: center;
}

#notify_chat::before {
  border-bottom: 8px solid #c0c0c0;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  content: "";
  height: 0;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: -8px;
  width: 0;
}
#notify_chat::after {
  border-bottom: 8px solid #f5f5f5;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  content: "";
  height: 0;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: -6px;
  width: 0;
}
#textb:focus + #notify_chat {display:block;}

.grpone a.onlineUsers {
    float: right;
    font-size: 11px;
    text-decoration: underline;
}

p span { color: grey;}

</style>
 
</head>
<body>
<div class="grp_ceond" style="width:100% !important;">
						<?php 
							$nowtime = date('Y-m-d H:i:s');
							$gname=@mysql_query("select * from  chat_groups where id='$groupID' ");
							$group_dtl=@mysql_fetch_assoc($gname);
							$chk_user=mysql_query("select  user_id from  chat_users_groups where group_id='$groupID' ");
		   					$cnt_row=@mysql_num_rows($chk_user);
		   					$my_smilies = array(
								'@!' => '<img src="group-chat/smilies/barmy.gif"/>',
								'||' => '<img src="group-chat/smilies/bash.gif"/>',
								'[]' => '<img src="group-chat/smilies/bottle.gif"/>',
								'%#' => '<img src="group-chat/smilies/bike2.gif"/>',
								'!@' => '<img src="group-chat/smilies/cheer.gif"/>'
						    	);
							?>
							<div style="" class="ulist">
                    <!-- <div class="groupchatname"> <span style="font-size:18px;"> <?php echo $group_dtl['group_name']; ?></span> <span id="totalViewers">0 Viewers</span> </div> -->
                   <!-- <div class="joinbutton"> </div>-->
                    <div id="chatMembers">
                      <?php

							// echo "SELECT u.first_name,u.last_name,u.profilename,u.id,u.image_nm FROM   chat_users_groups as cg 
							// left join user as u on(u.id=cg.user_id) where cg.group_id='".$_GET['gr_id']."'"; exit;
// echo "SELECT *  FROM   chat_users_groups as cg where cg.group_id='".$ID."' "; exit;
							$result1 = mysql_query("SELECT *  FROM   chat_users_groups as cg where cg.group_id='".$groupID."' ");
					if(@mysql_num_rows($result1) > 0)
					{
						if($row1['user_id'] != 0)
	  					{
							while($row1 = mysql_fetch_array($result1))
						  	{
							  	if($row1['user_type'] == "club")
							  	{
							  		$QQ = mysql_query("SELECT `club_name`,`id`,`image_nm` FROM `clubs` WHERE `id` = '$row1[user_id]' ");
							  		$fetchClubs = mysql_fetch_array($QQ);
							  		$userNAme = $fetchClubs['club_name'];
							  		$poster = $fetchClubs['image_nm'];
							  	}
							  	else
							  	{
							  		$QQ = mysql_query("SELECT u.first_name,u.last_name,u.profilename,u.id,u.image_nm FROM `user` as u WHERE `id` = '$row1[user_id]' ");
							  		$fetchuser = mysql_fetch_array($QQ);
							  		if($fetchuser['profilename'] != "" && $fetchuser['profilename'] != " " )
							  		{
							  			$userNAme = $fetchuser['profilename'];
							  		}
							  		else
							  		{
							  			$userNAme = $fetchuser['first_name']." ".$fetchuser['last_name'];;
							  		}

							  		$poster = $fetchuser['image_nm'];
							  	}


							  	if($userNAme !="")
							  	{
							  		?>
                       								<p>
                       									<a href="javascript:void(0);">
                       										<span>
                       											<img height=25 width=25 src="../<?php echo $poster; ?>" />&nbsp;<?php echo $userNAme;?>
                       										</span>
                       									</a>
                       								</p>
                       			<?php	
							  	}
						  	}
					 	}
					}
					else
					{
					   	echo '<p>No Users Online In Current City</p>';
					}
							  ?>
                    </div>
                  </div>

							<div class="grpone" style="display:none;">

				<?php 
					if(!isset($_SESSION['user_id']) )
					{
						?>
						<p>Please <a onclick="goto('loginpop.php');" href="javascript:void(0);">Login</a> to Enter Chat Area</p>
						<?php
					}
					else
					{

					
					?>
					<a href="javascript:void(0);" class="onlineUsers" onclick="goto('fetchUsers.php?gID=<?php echo $groupID; ?>');">View online Users</a>
					<input  class="textb1"   name="message" type="text" id="textb"/>
			              <!--      <div id="notify_chat">
				                    <h2>Please Log in to chat</h2>
				                    <div class="clear"></div>
				                    <a class="logon" <?php if(!isset($_SESSION['user_id']) ){?> onclick="goto('loginpop.php');" <?php } ?> href="javascript:void(0);">Log in  or Sign up<i></i><em></em></a>
			       
			                    </div> -->
							<input name="submit1" type="button" value="Send" id="post_button" />

							<input name="sender" type="hidden" id="texta" value="<?php echo $_SESSION['username']?>"/>
 <div class="divider"></div>
							<div class="refresh" id="sc">

							<?php

							$result12 = mysql_query("SELECT * FROM message where group_id='$groupID'  AND  sent_time  > ( '$nowtime' - INTERVAL 1 HOUR )  ORDER BY id");
							$ccc = mysql_num_rows($result12);
							if( $ccc > 0)
							{
								while($row = @mysql_fetch_array($result12))
							  	{	
								  	if($row['sender'] == 'user')
									{
										$QQ = mysql_query("SELECT * FROM `user` WHERE `id` = '$row[sender]' ");
										$fetchUser = mysql_fetch_array($QQ);
										if($fetchUser['profilename'] == "" && $fetchUser['profilename'] == " ")
										{
											echo '<p>'.'<span>'.$row['first_name'].' '.$row['last_name'].':</span>'. '&nbsp;&nbsp;' . 	str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
										}
										else
										{
											echo '<p>'.'<span>'.$row['profilename'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
										}
									}
									else
									{
										$QQ = mysql_query("SELECT `club_name` FROM `clubs` WHERE `id` = '$row[sender]' ");
										$fetchUser = mysql_fetch_array($QQ);
										echo '<p>'.'<span>'.$row['club_name'].':</span>'. '&nbsp;&nbsp;' . str_replace( array_keys($my_smilies), array_values($my_smilies), $row['message']).'<span class="deleteMessage">x</span></p>';
									}
								 
							  	}
							 }
							 else
							 {
							 	echo "<p>No Messages Yet !</p>";
							 }
							?>

							</div>
			<?php 			if( $cnt_row > 0) 
						{ 

							?>
							
							
				<?php 		} 			?>
							
							</div>
							<?php } ?>
							</div>
<script language="javascript">
function test()
{

 window.top.location = "http://whatever.com";
  window.close();
 

}

function goto(url)
{
	window.open(url,'1396358792239','width=300,height=300,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=0,left=0,top=0');
	return false;
}

</script>
<script type="text/javascript">
 
function setchat(val)
{
    	var j = jQuery.noConflict();
	
	j('#textb').val(j('#textb').val() + val);

}

function deleteMessage(msgid)
{
	
	var j = jQuery.noConflict();
	j.ajax({
		url: "group-chat/refresh.php?group_id=<?php echo $groupID;  ?>&message_id="+msgid,
		cache: false,
		success: function(html)
		{
			j(".refresh").html(html);
			j('#sc').animate({
			    	scrollTop: j("#sc").get(0).scrollHeight
		    	}, 3000);
	  	}
	});

}

jQuery(document).ready(function(){

	// if(event.keyCode == 13)
	// {

	// 	return false;
	// }

	//jQuery("div.refresh").scrollTop(700);
  	var j = jQuery.noConflict();
	j(document).ready(function()
	{

		window.setInterval(function(){
			
			/*j.ajax({
				url: "refreshFrame.php?group_id=<?php echo $groupID;  ?>",
				cache: false,
				success: function(html)
				{
					j(".refresh").html(html);
					// j('#sc').animate({
					//     	scrollTop: j("#sc").get(0).scrollHeight
				 //    	}, 1000);
			  	}
			});*/
			j.ajax({
				url: "group-chat/refresh.php?group_id=<?php echo $groupID;  ?>&count=users",
				cache: false,
				success: function(html)
				{
					j("#chatMembers").html(html);
			  	}
			})
			j.ajax({
				url: "group-chat/refresh.php?group_id=<?php echo $groupID;  ?>&view=Viewers",
				cache: false,
				success: function(html)
				{
					j("span#totalViewers").html(html);
			  	}
			})
		}, 3000);
		
	});
	
	
	j(document).ready(function() {
		j("input").keypress(function(event) {
			if (event.which == 13)
			{
				event.preventDefault();
				$text = j('#textb').val();
				j('#textb').val('');
				if(j('#textb').val() != "")
				{
					j.ajax({
						type: "POST",
						cache: false,
						url: "group-chat/save.php",
						data: "text="+$text+"&group_id="+<?php echo $groupID; ?>+"&sender=<?php echo $_SESSION['user_id']; ?>",
						success: function(data) {
							//alert('data has been stored to database');
							
						    	j('#sc').animate({
							    	scrollTop: j("#sc").get(0).scrollHeight
						    	}, 1000);
						}
					});
				}
			}
		});
		j('#post_button').click(function() {
			//alert(j('#textb').val());
			$text = j('#textb').val();
			j('#textb').val('');
			if(j('#textb').val() != "")
			{
				j.ajax({
					type: "POST",
					cache: false,
					url: "group-chat/save.php",
					data: "text="+$text+"&group_id=<?php echo $groupID;?>&sender=<?php echo $_SESSION['user_id']; ?>",
					success: function(data) {
						//alert('data has been stored to database');
						//j('#textb').val('');
						j('#sc').animate({
						    	scrollTop: j("#sc").get(0).scrollHeight
					    	}, 1000);
					}
				});
			}
		});
	});
j('.textb1').click(function () {        
		//append .focus() to focus the text
		j('#notify_chat').fadeIn('slow');
		});

 
});

function blockUser(uid)
{
	var j = jQuery.noConflict();
	j.ajax({
		url: "group-chat/refresh.php?group_id=<?php echo $groupID;  ?>&deleteuserid="+uid,
		cache: false,
		success: function(html)
		{
			j(".refresh").html(html);
			j('#sc').animate({
			    	scrollTop: j("#sc").get(0).scrollHeight
		    	}, 3000);
	  	}
	});
}

</script>

</body>
</html>

