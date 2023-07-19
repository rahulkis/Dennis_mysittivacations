<?php
ob_start();
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage="Invite Friends";
// include('LoginHeader.php');
include('NewHeadeHost.php');

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];

/* start code friend list  */

if(isset($_GET['id']))
{
	$UID = $_GET['id'];
}
else
{
	$UID = $_SESSION['user_id'];
}

if($_SESSION['user_id']!="" )
{
	$sql4="select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$UID."' AND `user_type` = 'user' AND fs.friend_id != 1 AND fs.friend_id != '$UID' AND fs.status IN ('active','block')
		GROUP BY friend_id ORDER BY id ASC";

}
else
{
  	$Obj->Redirect("login.php");die;
}
$sql6 = mysql_query($sql4);
$sql_frnd = mysql_query($sql4);

$friends_value = array();
while($searchfrnd1 = mysql_fetch_assoc($sql_frnd)) {
  
  if($searchfrnd1['friend_type'] == 'user'){
	$friend_query = mysql_query("SELECT profilename FROM user WHERE id = '".$searchfrnd1['friend_id']."'");
	$get_friend_name = mysql_fetch_assoc($friend_query);
	$frnd_name = $get_friend_name['profilename'];
  }
  
  if($searchfrnd1['friend_type'] == 'club'){
	$friend_query = mysql_query("SELECT club_name FROM clubs WHERE id = '".$searchfrnd1['friend_id']."'");
	$get_friend_name = mysql_fetch_assoc($friend_query);
	$frnd_name = $get_friend_name['club_name'];
  }
  
  if(!empty($frnd_name)){
	  $friends_value[] = $frnd_name;
  }
}

$num = mysql_num_rows($sql6);

/* end code friend list  */

$fetmetaquery = @mysql_query("SELECT * FROM `facebookshare` ORDER BY `id` DESC limit 1 ");
$fetchmetacontent = @mysql_fetch_array($fetmetaquery);
$countinfo = @mysql_num_rows($fetmetaquery);

if($countinfo > 0)
{
	$image = $fetchmetacontent['image'];
	$description = $fetchmetacontent['description'];
}
else
{
	$image = "images/banner2.jpg";
	$description = "Making Every City Your City";
}
 //include('header_start.php') ;?>

<script type="text/javascript">
function isLogin() {
	if (confirm("Please login to view profile. ")) {
	 document.location = "login.php";
	}
}
 function requestFriend(id, from, to)
 {
	 $.get('send-request.php?friend_id='+id+'&from_user_type='+from+'&to_user_type='+to, function(data) {
			$('#request_'+id).html("Requested");
		});
 }
 
 function getcityvalue(state)
{
	$.get('getcity.php?state_id='+state, function(data) {   
	$('#get_city_name').html(data);
	});
}
</script>

<style>
.login table{
border-collapse:collapse;
text-align:left;
border:1px solid blue;
}

.login table tr td{
border:1px solid blue;
}

#city_state_show_d{
	display: none;
}
</style>
<?php 
//echo "<pre>"; print_r($_SESSION);exit;
if(isset($_POST['country']))
{
		$country1 = $_POST['country'];
}
else
{
		$country1 = $_SESSION['country'];
}

if(isset($_POST['state']))
{
		$state1 = $_POST['state'];
}
else
{
		$state1 = $_SESSION['id'];
}

if(isset($_POST['city']))
{
		$city1 = $_POST['city'];
}
else
{
		$city1 = $_SESSION['usercity'];
}


$sql= @mysql_query("select * from country where country_id='".$country1."'");
$sql1 = @mysql_fetch_array($sql);
$con = $sql1['name'];

if($_POST['state']!="" )
{
	$cnd=" AND  u.state='".$_POST['state']."'";
}
if($_POST['city_name']!="" )
{
	$cnd.=" AND  u.city='".$_POST['city_name']."'";
}

 require_once("admin/paging.php");
 
 
if($_POST['state']!="" )
{
	$u_cnd=" AND state='".$_POST['state']."'";
}
if($_POST['city_name']!="" )
{
	$u_cnd.=" AND city='".$_POST['city_name']."'";
}
if($_POST['pname']!="" )
{
	$u_cnd.=" AND ( first_name LIKE '%".$_POST['pname']."%' OR last_name LIKE '%".$_POST['pname']."%' OR email LIKE '%".$_POST['pname']."%' )";
}

if($_POST['state']!="" )
{
	$h_cnd=" AND club_state='".$_POST['state']."'";
}
if($_POST['city_name']!="" )
{
	$h_cnd.=" AND club_city='".$_POST['city_name']."'";
}
if($_POST['pname']!="" )
{
	$h_cnd.=" AND ( club_name LIKE '%".$_POST['pname']."%' OR club_email LIKE '%".$_POST['pname']."%' )";
}

$sql_forfrnd = mysql_query("SELECT first_name,last_name,email FROM `user` where id not in (SELECT friend_id FROM `friends` where user_id=".$_SESSION['user_id']." ) ".$u_cnd." AND `id` != '1' AND `id` != '1269' AND email != ''");
//$sql_forfrnd=mysql_query("SELECT first_name,last_name FROM `user`");
$count_sqlforfrnd=mysql_num_rows($sql_forfrnd);

$frnd_sqlforfrnd=array();
 //$i=0;
 while($row_forfrnd=mysql_fetch_assoc($sql_forfrnd)){
	 //$frnd_sqlforfrnd[$i]=$row_forfrnd['first_name'].$row_forfrnd['last_name'];
		 $frnd_sqlforfrnd[]=$row_forfrnd['first_name'];
		 $frnd_sqlforfrnd[]=$row_forfrnd['email'];
	 //$i++;
 }
 
$sql_forhost = mysql_query("SELECT club_name as first_name, club_email as email FROM `clubs` WHERE non_member = '0' ".$h_cnd." AND club_email != ''");
$count_sqlforhost = mysql_num_rows($sql_forhost);
 
 $frnd_sqlforhost=array();
 //$i=0;
 while($row_forhost=mysql_fetch_assoc($sql_forhost)){
	 //$frnd_sqlforfrnd[$i]=$row_forfrnd['first_name'].$row_forfrnd['last_name'];
 	$clubEmail = $row_forhost['email'];
// 	echo "SELECT `id` FROM `hostsubusers` WHERE `useremail` LIKE '%$clubEmail%' "; echo "<br />";
 	$checkSubuser = mysql_query("SELECT `id` FROM `hostsubusers` WHERE `useremail` LIKE '%$clubEmail%' ");
 	if(mysql_num_rows($checkSubuser) == '0')
 	{
		$frnd_sqlforhost[] = $row_forhost['first_name'];
		$frnd_sqlforhost[] = $row_forhost['email'];
	}
}

 $all_members_arr = array();
 
 if(!empty($frnd_sqlforfrnd) && empty($frnd_sqlforhost)){
	
	$all_members_arr = $frnd_sqlforfrnd;
	
 }elseif(empty($frnd_sqlforfrnd) && !empty($frnd_sqlforhost)){
	
	$all_members_arr = $frnd_sqlforhost;
	
 }else{
	
	$all_members_arr = array_merge($frnd_sqlforfrnd, $frnd_sqlforhost);
	
 }

//
//echo json_encode($frnd_sqlforfrnd);
 
$final_all_members = $all_members_arr;
/*---------------------------------------------------------------------------------------------------------------------------------------------------*/


//echo "SELECT first_name,last_name FROM `user` where id not in (SELECT friend_id FROM `friends` where user_id=".$_SESSION['user_id']." ) ";
$sql_forfrnd12 = mysql_query("SELECT first_name,last_name,email FROM `user` where id not in (SELECT friend_id FROM `friends` where user_id=".$_SESSION['user_id'].") AND `id` != '1' AND `id` != '1269' ");
//$sql_forfrnd=mysql_query("SELECT first_name,last_name FROM `user`");
$count_sqlforfrnd12=mysql_num_rows($sql_forfrnd12);

$frnd_sqlforfrnd12=array();
 //$i=0;
 while($row_forfrnd12=mysql_fetch_assoc($sql_forfrnd12)){
	 //$frnd_sqlforfrnd[$i]=$row_forfrnd['first_name'].$row_forfrnd['last_name'];
		 $frnd_sqlforfrnd12[]=$row_forfrnd12['first_name'];
		 $frnd_sqlforfrnd12[]=$row_forfrnd12['email'];
	 //$i++;
 }
 
$sql_forhost12 = mysql_query("SELECT club_name as first_name, club_email as email FROM `clubs` WHERE non_member = '0'");
$count_sqlforhost12 = mysql_num_rows($sql_forhost12);
 
 $frnd_sqlforhost12=array();
 //$i=0;
 while($row_forhost12=mysql_fetch_assoc($sql_forhost12)){
	 //$frnd_sqlforfrnd[$i]=$row_forfrnd['first_name'].$row_forfrnd['last_name'];
 	$clubEmail = $row_forhost12['email'];
// 	echo "SELECT `id` FROM `hostsubusers` WHERE `useremail` LIKE '%$clubEmail%' "; echo "<br />";
 	$checkSubuser = mysql_query("SELECT `id` FROM `hostsubusers` WHERE `useremail` LIKE '%$clubEmail%' ");
 	if(mysql_num_rows($checkSubuser) == '0')
 	{
		$frnd_sqlforhost12[] = $row_forhost12['first_name'];
	 	$frnd_sqlforhost12[] = $row_forhost12['email'];
	}

	 //$i++;
 }
 
	$all_members_arr12 = array();
 
 if(!empty($frnd_sqlforfrnd12) && empty($frnd_sqlforhost12)){
	
	$all_members_arr12 = $frnd_sqlforfrnd12;
	
 }elseif(empty($frnd_sqlforfrnd12) && !empty($frnd_sqlforhost12)){
	
	$all_members_arr12 = $frnd_sqlforhost12;
	
 }else{
	
	$all_members_arr12 = array_merge($frnd_sqlforfrnd12, $frnd_sqlforhost12);
	
 }

//
//echo json_encode($frnd_sqlforfrnd);
 
$final_all_members12 = $all_members_arr12;
?>
<script type="text/javascript">
	var friendlist_forfrnd = new Array();
	 
	<?php if($final_all_members12){ ?>
		
	friendlist_forfrnd = <?php echo json_encode($final_all_members12); ?>;
	
	<?php } ?>
		
</script>
<!--<script type='text/javascript' src='js/autocompletemultiple/jquery.js'></script>-->
<script type='text/javascript' src='js/autocompletemultiple/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="js/autocompletemultiple/jquery.autocomplete.css" />
<!--<link rel="stylesheet" type="text/css" href="https://mysitti.com/css/new_portal/style.css" />-->

<script type="text/javascript">
$(document).ready(function() {
	
	$("#pname").autocomplete(friendlist_forfrnd, {
		multiple: false,
		mustMatch: false,
		autoFill: false
	});
	
});
</script>
<script src="http://connect.facebook.net/en_US/all.js"> </script>
	 <script>
		 FB.init({ 
			 appId:'688073574590787', cookie:true, 
			 status:true, xfbml:true 
		 });
function FacebookInviteFriends()
{
FB.ui({ method: 'apprequests', 
	 message: 'My diaolog...'});
}
</script>
	 
	 
<div class="v2_container">
	<div class="v2_inner_main">
	
	<?php
	 if($_SESSION['user_type'] == 'club'){

		include('club-right-panel.php');                   

	}

	if($_SESSION['user_type'] == 'user'){

		if(!isset($_REQUEST['id'])){

			include('friend-right-panel.php');

		}else {

			include('friend-profile-panel.php');

		}                 

	}
	?>
	
	<article class="forum_content v2_contentbar">
		<div class="v2_rotate_neg">
			<div class="v2_rotate_pos">
				<div class="v2_inner_main_content">
					<?php 
						if($_SESSION['user_type'] == "user")
						{
							include('commonpage.php');
						} 
					?>
							 <div class="tbl_div"> 
										<!--<div class="invitesearch invite_frnds">
												<style type="text/css">
												.at15t_twitter, .at16nc.at16t_twitter
												{
														background: url("images/twitter.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
														height: 32px;
														width: 32px;
												}
		
		
												</style>
												<a href="javascript:TB_show('Send invitation to friend/faimly for pledge', 'user_pledge_invite.php?user=testuserTB_iframe=true&amp;height=400&amp;width=450', '', './images/trans.gif');"></a>  
											 <h3>  Invite Friends from other Accounts </h3>
										<?php
		
														// if(isset($_POST['invite_user']))
														// {
		
																// include('invite_email_sent.php');
														// }
										?>
												<form method="POST" action="" name="frminvite" id="frminvite">
														<div class="row">
																<span class="label">Friend's name<font color='red'>*</font></span>
																<span class="formw">
																		<input type="text" class="inp5" id="invite_message" name="invite_message">
																<br />
																</span>
														</div>
		
														<div class="row">
																<span class="label">Email<font color='red'>*</font></span>
																<span class="formw">
																		<input type="text" class="inp5" id="invite_emails" name="invite_emails">
																<br />
																</span>
														</div>
		
		
														<div class="row">
																<span class="formw f_txt">
																	<p>You can also invite friends using your Facebook, Twitter address book.</p>
																</span>
														</div>
		
													
														<div class="row">
																<span class="formw" style="width:50% !important;float:left">
																		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5208c23564631929" async></script>
																		<div class="addthis_sharing_toolbox"></div>
																</span>
																<div class="clear"></div>
																<span style="float: left; ">
																	<input value="Send Invitation" style=" float: right;margin-right:0px !important" type="submit" class="button" name="invite_user">
																</span>
																
														</div>
		
														<div class="row" style="">                   
																<span class="formw">
																</span>
														</div>
														<input type="hidden" name="host_id" value="<?php echo $_SESSION['user_id'];?>" /> 
												</form>
										</div>-->
										
										<div id="city_search_u" class="invite_frnds">
										 <h3>Friends</h3>
												<form name="user_serach" action="" method="post" id="user_search_form">
												
													<div id="city_state_show_d">
														<div class="row">
															<span class="label" style=" ">State</span>
															<span class="formw">
															
															<select name="state" id="state" onchange="getcityvalue(this.value);">
																	<option value="">- -Select- -</option>
																	<?php 
																	$countrysql1="select zone_id,name from zone where country_id=223";
																	$country_list1 = mysql_query($countrysql1);
																	?>
																	
																	<?php 
																	while($row1 = mysql_fetch_array($country_list1))
																	{
																	?>
																	
																	<option value="<?php echo $row1["zone_id"]; ?>" <?php if($_POST['state']==$row1["zone_id"]) { ?> selected="selected" <?php } ?> ><?php echo $row1["name"]; ?></option>
																	<?php
																	}
																	
																	?>
																	</select>
																	</span>
														</div>
														
														<div class="row">
															<span class="label" style=" ">City</span>
															<span class="formw">
															<select name="city_name" id="get_city_name" >
															<?php if($_POST['city_name']) {
																
																$get_c_name = @mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$_POST['city_name']."'");
																$get_c = mysql_fetch_assoc($get_c_name);
																
																
																?> <option value="<?php echo $_POST['city_name']; ?>"><?php echo $get_c['city_name']; ?></option> <?php }else{ ?>
															<option value="">--Select--</option>
															<?php } ?>
															</select>
															
															</span>
														</div>
													</div>
													
														<div class="row">
														<span class="label" style=" ">Profile Name: </span>
														<span class="formw"><input type="text" name="pname" requried  id="pname" value="<?php echo $_POST['pname']; ?>"></span>
														
														<div class="btn_center" style="float: left;">
															<input class="button" type="submit" value="Search" name="submit" id="submit" style="float:right;"/>
														</div></div>
														<div class="clear"></div>
														<div class="btn_center" style="">
															<!--<input class="button" value="Advance" id="adv_search" style="float:right;"/>-->
															<p id="adv_search" style="float:left; cursor:pointer;">Advance Search</p>
														</div>

														
														
														
												
												</form>
										</div>
										
								</div>    
								<?php
									if(!isset($_POST['pname']) || !isset($_POST['city_name']) || !isset($_POST['state'])) {
										$count_members = 19;
										echo "<div><h3 id='title' class='suggested_frnd'>My Friends</h3></div>";
									} else {
										$count_members = count($final_all_members);
									}
								?>
								
								<div class="mysittisearch">
									<?php   // start friend list code
									if($num==0)
									{
										?>
										<div class="err NoRecordsFound" id="middle" style="margin-left:50px; background-color:#000; border:hidden;width:900px; min-height:0;">
											<?php 
											$nofriMsg = "You dont have any friend request";

											echo $nofriMsg; ?>	
										</div>
										<?php
									}
									else
									{
										?>

																						
								 		<?php
							  			$i=0;
									 	while($sql5=@mysql_fetch_array($sql6))
										{
											$i++;
											if($sql5['friend_type'] == "user")
											{
												$friendQuery  = mysql_query("SELECT `profilename`,`id`,`is_online`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
																	FROM `user` 
																	WHERE `id` = '$sql5[friend_id]'
																");
												$friendResult = mysql_fetch_assoc($friendQuery);
												if($friendResult['profilename'] != "")
												{
													$friendName = $friendResult['profilename'];
												}
												else
												{
													$friendName = $friendResult['first_name']." ".$friendResult['last_name'];
												}

												$friendCityid = $friendResult['city'];
												$friendStateid = $friendResult['state'];
												$friendCountryid = $friendResult['country'];
												$friendID = $friendResult['id'];
												$friendZip = $friendResult['zipcode'];
												$friendSattus = $friendResult['status'];
												$imageSrc = $friendResult['image_nm'];
												$anchorPath =	"profile.php?id=".$friendID;
												$onlineStatus = $friendResult['is_online']; 
												$current_to_user_type = 'user';

											}
											else
											{
												$friendQuery  = mysql_query("SELECT `id`,`is_online`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
																	FROM `clubs` 
																	WHERE `id` = '$sql5[friend_id]'
																	AND `non_member` = 0
																");
												$friendResult = mysql_fetch_assoc($friendQuery);
												$friendName = $friendResult['club_name'];
												$friendCityid = $friendResult['club_city'];
												$friendStateid = $friendResult['club_state'];
												$friendCountryid = $friendResult['club_country'];
												$friendID = $friendResult['id'];
												$friendZip = $friendResult['zip_code'];
												$friendSattus = $friendResult['status'];
												$imageSrc = $friendResult['image_nm'];
												$anchorPath =	"host_profile.php?host_id=".$friendID;
												$onlineStatus = $friendResult['is_online'];
												$current_to_user_type = 'club';
											}

											
											$countrysql = @mysql_query("SELECT * FROM `country` WHERE country_id = '$friendCountryid' ");
											$countryfetch = @mysql_fetch_array($countrysql);
											$statesql = @mysql_query("SELECT * FROM `zone` WHERE zone_id = '$friendStateid' ");
											$statefetch = @mysql_fetch_array($statesql);
											$citysql = @mysql_query("SELECT * FROM `capital_city` WHERE city_id = '$friendCityid' ");
											$cityfetch = @mysql_fetch_array($citysql);
											if(trim($friendName) != "")
											{
												?>
													
												  	<div id="friendFrnd" class="v2_friend_listing" style="overflow: hidden; position: relative;">
													  	<div class="infodiv">
														  	<div class="image_friends">
																<?php
															  	if($imageSrc!="")
															 	{
							  										?>
							  										<a href="<?php echo $anchorPath; ?>">
																		<img  height="50px" width="50px" src="<?php echo $imageSrc; ?>" alt="" />
																	</a>
								 								<?php 	}  else { 	?>
																 	<a href="<?php echo $anchorPath; ?>">
																 		<img height="50px" width="50px" src="images/man4.jpg"  alt=""/>
																 	</a>
																<?php } ?>
															</div>

															<div class="address_friends">
																<div><?php echo $friendName; ?></div>
																<div>mei_yi1999@hotmail.com</div>
																<div><?php echo $countryfetch['name'] ; ?></div>
																<div><?php echo $statefetch['name'];  ?></div>
																<div><?php echo $cityfetch['city_name'] ; ?></div>
															</div>
														</div>
													</div>

														
										<?php
											} // eND IF USERNAME	  
							   			} // WHILE END
							   		}
								// end friend list code	?> 
								<div class="clear"></div>
								<?php 
								if($nofriMsg) { ?>
							    	<input type="submit" id="loadMore_fri" name="submit" value="Load More" class="button" style="display: none;">
							    	<?php } else { ?>
							    		<input type="submit" id="loadMore_fri" name="submit" value="Load More" class="button">
							    <?php	} ?>
								<?php
									if(!isset($_POST['pname']) || !isset($_POST['city_name']) || !isset($_POST['state'])) {
										$count_members = 19;
										echo "<div><h3 id='title' class='suggested_frnd'>Suggested Friends</h3></div>";
									} else {
										$count_members = count($final_all_members);
									}
								?>	
								<?php  
								if(count($final_all_members) == 0)
								{
								?>
									<div class="err NoRecordsFound" id="middle" style="border:hidden;">
										
										<?php if($_POST['pname'] != "" && $_POST['state'] == "" && $_POST['city_name'] == ""){
											
															 echo "No user data found with this profile name";
														
														}elseif($_POST['pname'] == "" && $_POST['state'] == "" && $_POST['city_name'] != ""){
											
															 echo "No user data found with this city name";
														
														}elseif($_POST['pname'] == "" && $_POST['state'] != "" && $_POST['city_name'] == ""){
											
															 echo "No user data found with this state name";
														
														}elseif($_POST['pname'] != "" && $_POST['state'] != "" && $_POST['city_name'] == ""){
											
															 echo "No user data found with this state and profile name";
														
														}elseif($_POST['pname'] == "" && $_POST['state'] != "" && $_POST['city_name'] != ""){
											
															 echo "No user data found with this state and city name";
														
														}else{
										
															 echo "No data found matching your criteria";
														} ?>
									</div>
									
									
									 <div style=" padding: 5px; float: left; width: 100%;"></div>
								<?php
								}
								else
								{

								 
									
									$j = 1;
									$k = "";
									
									for($i=0; $i<=$count_members; $i++) {	
										$k = $i + $j;
										
										if(!empty($final_all_members[$k])) {
										
										$check_from_user = mysql_query("SELECT * FROM user WHERE email = '".$final_all_members[$k]."'");
										$count_check_user = mysql_num_rows($check_from_user);
										
										if($count_check_user == 1) {
											$FriendType = 'user'; 
											$fetch_userdata = mysql_fetch_assoc($check_from_user);
											
											$username = $fetch_userdata['first_name']." ".$fetch_userdata['last_name'];
											$email = $final_all_members[$k];
											$profile_pic = $fetch_userdata['image_nm'];
											$profile_url = "<a href='profile.php?id=".$fetch_userdata['id']."'>";
											$userId = $fetch_userdata['id'];
											$current_to_user_type = "user";
										
											$get_country = mysql_query("SELECT name FROM country WHERE country_id = '".$fetch_userdata['country']."'");
											$country_name = mysql_fetch_assoc($get_country);
											$country = $country_name['name'];
											
											$get_state = mysql_query("SELECT name FROM zone WHERE zone_id = '".$fetch_userdata['state']."'");
											$state_name = mysql_fetch_assoc($get_state);
											$state = $state_name['name'];
											
											$get_city = mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$fetch_userdata['city']."'");
											$city_name = mysql_fetch_assoc($get_city);
											$city = $city_name['city_name'];
											
										} else {
										
										$check_from_club = mysql_query("SELECT * FROM clubs WHERE club_email = '".$final_all_members[$k]."'");
										$count_check_club = mysql_num_rows($check_from_club);
										
										if($count_check_club == 1){
											$FriendType = 'club'; 
											$fetch_hostdata = mysql_fetch_assoc($check_from_club);
											
											if(!empty($fetch_hostdata['club_name'])){
												
												 $username = $fetch_hostdata['club_name'];
												
											}else{
												
												 $username = $fetch_hostdata['first_name']." ".$fetch_hostdata['last_name'];
												
											}
										 
											$email = $final_all_members[$k];
											$profile_pic = $fetch_hostdata['image_nm'];
											$profile_url = "<a href='host_profile.php?host_id=".$fetch_hostdata['id']."'>";
											$userId = $fetch_hostdata['id'];
											$current_to_user_type = "club";
										
											$get_country = mysql_query("SELECT name FROM country WHERE country_id = '".$fetch_hostdata['club_country']."'");
											$country_name = mysql_fetch_assoc($get_country);
											$country = $country_name['name'];
											
											$get_state = mysql_query("SELECT name FROM zone WHERE zone_id = '".$fetch_hostdata['club_state']."'");
											$state_name = mysql_fetch_assoc($get_state);
											$state = $state_name['name'];
											
											$get_city = mysql_query("SELECT city_name FROM capital_city WHERE city_id = '".$fetch_hostdata['club_city']."'");
											$city_name = mysql_fetch_assoc($get_city);
											$city = $city_name['city_name'];                      
											
											
										}
									}
										?>
										
										
										<div id="suggestedFrnd" class="v2_friend_listing" style="overflow:hidden; position:relative;" >
												<div class="infodiv">
													<div class="image_friends"> <!--class="profileicon"-->
														
														<?php echo $profile_url; ?>
															
															<?php if(empty($profile_pic)){ ?>
															
																<img src="images/man4.jpg"  alt="" />
															
															<?php }else{ ?>
															
																<img src="<?php echo $profile_pic; ?>"  alt=""/>
															
															<?php } ?>
																					
														</a>
													</div>
													<div class="address_friends">
														<?php
															echo "<div>".$username ."&nbsp;</div><div></div>".$email."<div>". $country ."</div><div>".  $state . "</div><div>". $city . "</div>";
														?>
													</div>
														
												
												<div class="chatoption">
												
														<span id="request_<?php echo $userId;?>">
														
															<?php
															if($FriendType == 'user' )
															{
																$ck = mysql_query("select status from  friends where friend_id = '".$userId."' AND user_id = '".$_SESSION['user_id']."' AND user_type = '".$_SESSION['user_type']."' AND friend_type = '".$current_to_user_type."'");
															}
															else
															{
																$ck = mysql_query("select status from  friends where user_id = '".$userId."' AND friend_id = '".$_SESSION['user_id']."' AND friend_type = '".$_SESSION['user_type']."' AND user_type = '".$current_to_user_type."'");
															}
															
															$f_sts = mysql_fetch_array($ck);
															//echo $f_sts['status']."--".$current_to_user_type."--".$userId;
															if($f_sts['status']=="pending" &&  $_SESSION['user_id'] != $userId){ ?>
															<span style="float: left; font-weight: bold; color: rgb(254, 205, 7);  width:100%; text-align:center;">Already Requested</span>
															<?php } else if($f_sts['status'] != "active" && $_SESSION['user_id'] != $userId){ ?>
															
															<a href="javascript:void(0);" onclick="requestFriend('<?php echo $userId;?>', '<?php echo $_SESSION['user_type']; ?>' , '<?php echo $current_to_user_type; ?>');" class="button-a">Send Peep Request </a>
															<?php }
															elseif($f_sts['status']=="active" && $_SESSION['user_id'] != $userId){ ?>
																<span style="float: left; font-weight: bold; color: rgb(254, 205, 7); width:100%; text-align:center;">Already Firends</span>
															<?php } ?>
														</span>
														
													</div>
												</div>  
										</div>                    
																			
								<?php  
									$j++; 
										}
									}
								} 
								?>
								<div id="right2">
									<div class="advertise" style="margin-top:30px; border:hidden"></div>
									<div class="advertise" style="border:hidden"></div>
								</div>                  
							 </div>   
							    <div class="clear"></div>
							    <input type="submit" id="loadMore" name="submit" value="Load More" class="button">           
								
								</div>
						</div>
				</div>
		</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		size_div = $(".mysittisearch div#suggestedFrnd").size();

		    x=3;

		    $('.mysittisearch div#suggestedFrnd:lt('+x+')').show();
		    $('#loadMore').click(function () {

		        x= (x+<?php echo $count_members; ?> <= size_div) ? x+<?php echo $count_members; ?> : size_div;
		        $('.mysittisearch div#suggestedFrnd:lt('+x+')').show();
		    });

		size_div = $(".mysittisearch div#friendFrnd").size();
		    y=3;
		    
		    $('.mysittisearch div#friendFrnd:lt('+y+')').show();
		    $('#loadMore_fri').click(function () {
		        y= (y+<?php echo $count_members; ?> <= size_div) ? y+<?php echo $count_members; ?> : size_div;
		        $('.mysittisearch div#friendFrnd:lt('+y+')').show();
		    });

		$('#adv_search').click(function(){
				if ($.trim($(this).text()) === 'Advance Search') {
					$(this).text('Hide Advance Search');
					$('#city_state_show_d').show();
				} else {
					$(this).text('Advance Search');
					$('#city_state_show_d').hide();
				}			
		});	

	});
</script>
<style>
	.mysittisearch div#suggestedFrnd {
	 display:none;
	}
	.mysittisearch div#friendFrnd {
	 display:none;
	}
</style>
<?php include('Footer.php') ?>