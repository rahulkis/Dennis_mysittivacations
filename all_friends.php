<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;

$titleofpage="Friends List";
include ('NewHeadeHost.php');

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

if(isset($_POST['makeclosefriendID'])){
 	$userID=$_SESSION['user_id'];
	$userType= $_SESSION['user_type'];
	$makeclosefriendID=$_POST['makeclosefriendID'];
	$statustext=$_POST['statustext'];
	
	$update_sqltext="update friends set close_friend='".$statustext."' where user_id='".$userID."' and friend_id='".$makeclosefriendID."'";
	$sqldatetext=mysql_query($update_sqltext);die;
	
}
?>
<script type="text/javascript">
$(document).ready(function(){
	$(".makeclosefriend").click(function(){
		var makeclosefriendID1 = $(this).attr('id');
		var makeclosefriendID = makeclosefriendID1.split('_');
		makeclosefriendID = makeclosefriendID[1];
		//alert(makeclosefriendID);
		if($('#'+makeclosefriendID1).is(':checked')){
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
	});
	
	var search_friend_list = new Array();
	   
	search_friend_list = <?php echo json_encode($friends_value); ?>;
	
	$("#search_friend").autocomplete(search_friend_list, {
		multiple: false,
		mustMatch: true,
		autoFill: true
	});	
});

function requestBlock(id,ac)
{
	if(confirm("Are yo sure you want to BLOCK AND REMOVE this friend from your friend list ?"))
	{
		$.get('request-block.php?f_id='+id+'&action='+ac, function(data) {
			//window.location.href = 'all_friends.php';
			$('#request_'+id).html(data);
		});
	}
}

function search_friend(){
  var friend_name = $('#search_friend').val();
  
  if (friend_name != "") {
  $.post('ajaxcall.php', { 'search_user_friend':friend_name }, function(response){
	
	$('#middle').empty();
	$('#middle').html(response);
  });
  }

}
</script>
<style>
.display.loadmusic.v2_connections.dataTable.no-footer .button.button_view {
  background: #00baff none repeat scroll 0 0;
  border: 0 none;
  box-shadow: none !important;
  color: #000 !important;
  min-width: auto !important;
}
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 
		if(isset($_GET['id']))
		{
			include('friend-profile-panel.php');
		}
		else
		{
			include('friend-right-panel.php');
		}
		?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
						<?php include('commonpage.php');?>
						<h3 id="title">
							<?php 
							if(!isset($_GET['id']))
							{
								echo $_SESSION['profile_name'].' Peeps';
							}
							else
							{
								$getUname = mysql_query("SELECT * FROM `user` WHERE `id` = '$UID' ");
								$fetchUname = mysql_fetch_assoc($getUname);
								echo $fetchUname['profilename'].' Peeps';


								// $getFriends = mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs where fs.user_id='".$_SESSION['user_id']."' AND `user_type` = '$_SESSION[user_type]' AND fs.friend_id != 1 AND fs.friend_id != '$_SESSION[user_id]' GROUP BY friend_id ORDER BY id ASC");
								// $sq = 0;
								// while($r = mysql_fetch_assoc($getFriends))
								// {
								// 	$FriendsTypeArray[$sq] = $r['friend_type'];
								// 	$FriendsArray[$sq] = $r['friend_id'];
								// 	$FriendsArrayStatus[$sq] = $r['freindstatus'];
								// 	$sq++;
								// }


							}
						?>
						<div class="u_friend_search" style="display:none">
						  Search : <input placeholder="Friend Name" type="text" id="search_friend">
						  <img src="images/icon_search.png" onclick="search_friend();">
						</div></h3>
					  <?php  
						if($num==0)
						{
							?>
							<div class="err NoRecordsFound" id="middle" style="margin-left:50px; background-color:#000; border:hidden;width:900px; min-height:0;">
								<?php echo "You dont have any friend request"; ?>	
							</div>
							<?php
						}
						else
						{
							?>

							<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
							<script type="text/javascript" language="javascript" class="init">
							$(document).ready(function(){
							  $('#example').dataTable();
							});
							</script>
							
 
						 	<div id="middle" style="border:hidden; min-height:0;" >
							<div class="autoscroll">
									<table class='display loadmusic v2_connections' id='example' style='margin-top:10px;' >
										<thead>
										<tr bgcolor='#ACD6FE'>
											
											<th>Name</th>
											<th>Avatar</th>
											<th>State</th>
											<th>City</th>
											<th>Country</th>
											<!-- <th>Chat</th> -->
											<?php 
											if(!isset($_GET['id']))
											{
											?>
											<th>Action</th>
											<?php 
											}
											else
											{
												echo "<th>Action</th>";
											}
											?>
										</tr>
										</thead>
										<tbody>								
							
							
							
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
										<tr>
											<td>
												<?php echo $friendName; ?>
											</td>

										  	<td>
				<?php
											  	if($imageSrc!="")
											 	{
			  	?>									<a href="<?php echo $anchorPath; ?>">
															<img  height="50px" width="50px" src="<?php echo $imageSrc; ?>" alt="" />
														</a>
				 <?php 								} 
										 		else
										 		{
						?>
												 	<a href="<?php echo $anchorPath; ?>">
												 		<img height="50px" width="50px" src="images/man4.jpg"  alt=""/>
												 	</a>
						<?php } ?>	
										  	</td>
											
											<td>
											<?php echo $statefetch['name'];  ?>
											</td>
											
											
											<td>
		<?php echo $cityfetch['city_name'] ; ?>

											</td>
											
											<td>
											<?php echo $countryfetch['name'] ; ?>
											</td>
										
				<? /*<td>
								<?php 			if($onlineStatus=='1')
											{
							?>
											   	<!-- <a href="javascript:void(0);" class="users" onclick="sendsession('<?php echo $friendID; ?>');">
													<img src="images/camera.png" height="20" style="border: 0px;"> 
												</a> -->
												<a href="javascript:void(0);" class="users"  onclick="chatWith('<?php echo str_replace(" ", "-", $friendName); ?>');">
													<img src="images/chat.png" height="20" style="border: 0px;"> <br/>
												</a>
						 	<?php 				}
						 					else
					 						{
					 	?>
												<!-- <a href="javascript:void(0);" class="users" onclick="sendsession('<?php echo $friendID; ?>');">
													<img src="images/camera_offline.png" height="20" style="border: 0px;"> 
												</a> -->
												<a href="javascript:void(0);" class="users"  onclick="chatWith('<?php echo str_replace(" ", "-", $friendName); ?>');">
													<img src="images/chat_offline.png" height="20" style="border: 0px;"> <br/>
												</a>
						<?php 					} ?>
						
				</td> */ ?>
						
						<?php
						
						
						
											if(isset($_SESSION['user_id']))
											{
						?> 
												<!-- <td><a class="button button_view" href="<?php echo $anchorPath; ?>" class="button-a" > View Profile </a></td> -->

						<?php 					}				 

											if(isset($_SESSION['user_id']) && (!isset($_GET['id']))) 
											{ ?>
													<td><span id="request_<?php echo $sql5['f_id'];?>">
									<?php  //echo $sql5['status'];
											  		if($sql5['freindstatus'] == 'active')
										  			{ 
						?>
														<a href="javascript:void(0);" onclick="requestBlock('<?php echo $sql5['f_id'];?>','block','<?php echo $sql5['friend_type']; ?>');" class="button-a" ><IMG src="images/del-notification.png" alt="Remove" title="Remove" /></a>
						<?php     						}			?>
												</span></td>	
										<?php 	}
											else
											{
												echo "<td>";
												//echo "<pre>"; print_r($FriendsArray); print_r($FriendsArrayStatus); print_r($FriendsTypeArray);
												$getFriends = mysql_query("SELECT * FROM `friends` WHERE  `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' AND `friend_id` = '$friendID' AND `friend_type` = '$current_to_user_type' GROUP BY `friend_id` ORDER BY id ASC ");
												if(mysql_num_rows($getFriends) > 0)
												{
													$allreadyfriends = 'yes';
													$fetchResult = mysql_fetch_assoc($getFriends);
													$Status = $fetchResult['status'];
												}
												else
												{
													$getFriends1 = mysql_query("SELECT * FROM `friends` WHERE  `friend_id` = '$_SESSION[user_id]' AND `friend_type` = '$_SESSION[user_type]' AND `user_id` = '$friendID' AND `user_type` = '$current_to_user_type' GROUP BY `user_id` ORDER BY id ASC ");
													if(mysql_num_rows($getFriends1) > 0)
													{
														$allreadyfriends = 'yes';
														$fetchResult1 = mysql_fetch_assoc($getFriends1);
														$Status = $fetchResult1['status'];
													}
													else
													{
														$allreadyfriends = 'no';
													}
												}







												if($allreadyfriends == 'yes')
												{
													if($sql5['friend_id'] == $_SESSION['user_id'] && $sql5['friend_type'] == $_SESSION['user_type'])
													{

													}
													else
													{
														$key = array_search ($sql5['friend_id'], $FriendsArray);
														if($Status == 'active')
														{
											?>				
															<a href="javascript:void(0);" id="request_<?php echo $sql5['f_id'];?>" onclick="requestBlock('<?php echo $sql5['f_id'];?>','block','<?php echo $sql5['friend_type']; ?>');" class="button-a" ><IMG src="images/del-notification.png" alt="Remove" title="Remove" /></a>

											<?php			}
														elseif($Status == 'pending')
														{
											?>
															<a href="javascript:void(0);" class="button-a newSendrequest" >Already Requested</a>

											<?php			}
														// unset($FriendsArray[$key]);
														// unset($FriendsArrayStatus[$key]);
														// unset($FriendsTypeArray[$key]);
													}
												}
												else
												{
													if($sql5['friend_id'] == $_SESSION['user_id'] && $sql5['friend_type'] == $_SESSION['user_type'])
													{

													}
													else
													{
									?>			
													<a href="javascript:void(0);" onclick="requestFriend('<?php echo $friendID;?>', '<?php echo $_SESSION['user_type']; ?>' , '<?php echo $current_to_user_type; ?>');" class="button-a newSendrequest" id="request_<?php echo $friendID;?>">Send Peep Request </a>

									<?php 				}
												}
												
												echo "</td>";

											}
										 ?>
						
									
							</tr>					
								
									
					<?php
								} // eND IF USERNAME	  
				   			} // WHILE END
				   			echo "</div>"; // END MIDDLE DIV ELSE CONDITION ?>
							
								</tbody>
								</table>								
        </div>
							
						<?php }
							//echo "I = ".$i;?>
  					</div>
  				</div>
			</div>
   </div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javascript">
 	function requestFriend(id, from, to)
	{
		$.get('send-request.php?friend_id='+id+'&from_user_type='+from+'&to_user_type='+to, function(data) {
			$('#request_'+id).html("Requested");
		});
	}
</script>




<?php include('Footer.php') ?>