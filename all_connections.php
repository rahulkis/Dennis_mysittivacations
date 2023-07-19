<?php
include("Query.Inc.php") ;
$Obj = new Query($DBName) ;
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
  $Obj->Redirect("login.php");
}
//$titleofpage = "All Connections";




?>
<script type="text/javascript">
 function requestBlock(id,ac,ftype)
 {

    var r = confirm("Are you sure want to delete !");
    if (r == true) {
	  $.get('request-block.php?f_id='+id+'&action='+ac+'&friendtype='+ftype+'&page=connection', function(data) {
		//$('#request_'+id).html(data);
		window.location.href = 'all_connections.php';
	  });
    }  
  
 }


function chatsetting(action,id,f_id)
{
	
	//Use jQuery's ajax function to send it
	$.ajax({
		type: "POST",
		url: "chatsetting.php",
		data: {
			'action' : action,
			'id' : id,
			'f_id' : f_id
		},
		success: function(data){
		  if((action == 'disableall') || (action == 'enableall') )
		  {
			  //('span.disableall').html(data);
			  location.reload(true);
		  }
		  else
		  {
			  $('#enablechat_'+f_id).html(data);    
		  }
		

		}
	});
	
	//We return false so when the button is clicked, it doesn't follow the action
	return false;
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

#title > span.disableall {
	float: right;
	font-size: 13px;
	width: auto;
}
.v2_nav ul li ul {
  bottom: auto !important;
  top: 47px !important;
}
</style>
<?php
$titleofpage="All Connections";
if(isset($_GET['host_id']))
{
	include('NewHeadeHost.php');
}
else
{
	include('NewHeadeHost.php');	
}


/******* Delete Friends *******/
//if(isset($_POST['deleteFriends']))
//{
//	
//	echo "<pre>";
//	print_r($_POST);
//	echo "</pre>";
//	die;
//	
//	foreach($_POST['friendsArray'] as $delete)
//	{
//		$recordID = $delete;
//		$getRecorddetails = mysql_query("SELECT * FROM `friends` WHERE `id` = '$recordID' ");
//		$fetchRecorddetails = mysql_fetch_assoc($getRecorddetails);
//	// echo "<pre>"; print_r($fetchRecorddetails); echo "</pre>"; die;
//		$recordUserid = $fetchRecorddetails['user_id'];
//		$recordUsertype = $fetchRecorddetails['user_type'];
//		$recordFriendid = $fetchRecorddetails['friend_id'];
//		$recordFriendtype = $fetchRecorddetails['friend_type'];
//
//		/* DELETE MAIN RECORD FROM THE TABLE WHERE ID is $recordID */
//		mysql_query("DELETE FROM `friends` WHERE `id` = '$recordID' ");
//
//		/* DELETE OPPOSITE RECORD FROM THE OTHER USER Too */
//		mysql_query("DELETE FROM `friends` WHERE `user_id` = '$recordFriendid' AND `user_type` = '$recordFriendtype' AND `friend_id` = '$recordUserid' AND `friend_type` = '$recordUsertype' ");
//		$msg = "Records Deleted Successfully.";
//	}
//
//}
/******* Delete Friends *******/







if($_SESSION['user_id']!="" )
{

 //  $sql4="select distinct(f.friend_id),u.first_name,u.last_name,cc.city_name,z.name as state ,z.code,c.name as country,f.id as f_id,f.chat  from  friends as f 
 //  left join user as u on(f.friend_id=u.id)
 // left join capital_city as cc on(cc.city_id=u.city)
 // left join  zone as z on(cc.state_id=z.zone_id)
 // left join country as c on(c.country_id=z.country_id)
 // where f.status='active' AND  f.friend_type='user'  AND f.user_id='".$_SESSION['user_id']."'";


	$sql4 = "select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from mysittid_latest.friends as fs where fs.user_id='".$_SESSION['user_id']."' AND fs.friend_id != 1 AND fs.friend_id != '".$_SESSION['user_id']."' AND fs.status IN ('active') GROUP BY friend_id ORDER BY id ASC;";

$Pendingsql= mysql_query("select distinct(fs.friend_id),fs.friend_type, fs.user_type,fs.user_id,fs.status as freindstatus,fs.chat,fs.id as f_id from mysittid_latest.friends as fs
		where fs.friend_id='".$_SESSION['user_id']."' AND fs.friend_id != 1 AND fs.friend_type = '".$_SESSION['user_type']."' AND fs.user_id != '".$_SESSION['user_id']."' AND fs.status IN ('pending')
		GROUP BY user_id ORDER BY id ASC");
}
 $sql67=@mysql_query($sql4);
 // $sql111 = mysql_fetch_array($sql6);
 // echo "<pre>"; print_r($sql111); exit;
 $num=@mysql_num_rows($sql67);


$chatcheckquery = @mysql_query("SELECT * FROM `friends` WHERE chat= '0' AND `user_id` = '$_SESSION[user_id]' AND `user_type` = '$_SESSION[user_type]' ");
$countdisable = @mysql_num_rows($chatcheckquery);
?>
<script type="text/javascript">
 function requestAccept(id)
 {
 	$.get('request-accept.php?f_id='+id, function(data) {
		$('#request_'+id).html(data);
	 	window.location.href='all_connections.php';
	});
 }

</script>
<style>
.a_connections_xs span {
  float: left;
  margin-right: 10px !important;
}
.v2_connections a.button_remove{ font-size:12px;min-width: 66px; margin: 0px 1px; border:1px solid #3b3b3b  !important;float: none;}
.v2_connections a.button_remove:hover {color:#fff !important; background:#f00 !important; border:1px solid #f00 !important;float: none;}

.v2_connections a.button_view{ font-size:12px;min-width: 66px; margin: 0px 1px; border:1px solid #3b3b3b !important;float: none;}
.v2_connections a.button_view:hover {color:#000 !important; background:#fecd07 !important; border:1px solid #fecd07 !important;float: none;}
</style>
<?php


if($_GET['msg'] == "imported"){
   $msg = "Users List imported successfully";
}

if($_GET['msg'] == "updated"){
   $msg = "Friend profile updated successfully";
}

if($_GET['msg'] == "failed"){
   $msg = "Friend profile update failed";
}  	 
	 






?>
<script type="text/javascript">
	function selectAll()
	{
		if ($('#SelectAll').is(':checked')) {
			$('.others').attr('checked', true);
		} else {
			$('.others').attr('checked', false);
		}
	}
	
	function validate_connections_Form(){
	  	 $.blockUI({ css: {

			border: 'none',

			padding: '15px',

			backgroundColor: '#fecd07',

			'-webkit-border-radius': '10px',

			'-moz-border-radius': '10px',

			opacity: .8,

			color: '#000'

		},

		message: '<h1 class="remove_friend_list">Removing from Friend List.</h1>'

		});
			var deleteFriends = [];
			var oTable = $('#example').dataTable();
			var rowcollection =  oTable.$(".others:checked", {"page": "all"});
			rowcollection.each(function(index,elem){
				var checkbox_value = $(elem).val();
				deleteFriends.push(checkbox_value);
				//Do something with 'checkbox_value'
			});
			
			jQuery.post('ajaxcall.php', {'deleteFriends':deleteFriends}, function(response){
			
				setTimeout(function(){
					 window.location.href='all_connections.php';
				},1000);
			  
			});
			return false;
	}
</script>

<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   
		if(!isset($_GET['host_id']))
		{
			include('club-right-panel.php');	
		}
		else
		{ 
			include('host_left_panel.php');
		} 
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
					<script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>		  
					<script type="text/javascript" language="javascript" class="init">
					$(document).ready(function(){
					  $('#example').dataTable();
					});
					</script>
							<?php if(isset($_SESSION['friend_records_deleted'])){ ?>
							
							  <div class="success_message" id="successmessage"> <?php echo $_SESSION['friend_records_deleted']; ?></div>
							<?php
							unset($_SESSION['friend_records_deleted']);
							} ?>
							
							<?php if(!empty($msg)){ ?>
							  <div class="success_message" id="successmessage"> <?php echo $msg; ?></div>
							<?php } ?>
							
								 <h3 id="title">Fans</h3>
								 <span>Settings</span>
								 <!-- <div class="dropdown">
									  <button class="dropbtn">Dropdown</button>
									  <div class="dropdown-content">
									    <a href="#">Link 1</a>
									  </div>
								</div> -->
								<div class="a_connections_xs">              
									<span class="disableall">
									<?php 
									if($countdisable == "0")
									{
									?>
									<a onclick="chatsetting('enableall','all','all');" href="javascript:void(0);" class="button">Enable All Chat</a>
									<?php

									}
									else
									{
									?>
									<a onclick="chatsetting('disableall','all','all');" href="javascript:void(0);" class="button">Disable All Chat</a>

									<?php 
									}


									?>

									</span>
									<span class="disableall">
										<a class="button" href="import.php" >Import List</a>
									</span>
									<!--<span class="disableall">
										<a class="button" href="csv_template/Users-List-Template.csv" >Download Template</a>
									</span>-->
								</div>
								</div>
								<style type="text/css">
									.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}
								</style>

					  <?php  
						 // echo $count = mysql_num_rows($sql6);
						 

								if($num==0)
								{
									?>
										<div class="NoRecordsFound">
											<?php echo "You don't have any friends"; ?>	
										</div>
									<?php
								}
								else
								{
									?>
									 <div class="autoscroll">
									  <?php if($del_message) { ?>
					<p style="text-align: center;  color: red;"><?php echo $del_message;?></p>
					<?php } ?>
				 <form action="" method="POST" class="allConnect" onsubmit="return validate_connections_Form()">
				   	<table class='display  v2_connections' id='example' style='margin-top:10px;' >
						<thead>
						<tr bgcolor='#ACD6FE'>
							<th class="firsTh" width="100px">
      <div class="dell-all">        
        <input onclick="selectAll();" type="checkbox" name="allRecords" id="SelectAll" />  
        <input style="border: none; background: none; cursor: pointer;" type="submit" value="Delete All" name="deleteFriends" /> 
       </div>
       
       </th>
							<th>Name</th>
							<th>Avtar</th>
							<th>State</th>
							<th>City</th>
							<th>Zip Code</th>
							<!--<th>Chat</th>-->
							<th>Status</th>
							<!-- <th>View Profile</th> -->
							
						</tr>
						</thead>
						<tbody>
				<?php  
								$i=1;  
								while($sql5=@mysql_fetch_array($sql67))
								{                 

									if($i%2 == '0')
									{
										$class = " class='even' ";
									}
									else
									{
										$class = " class='odd' ";
									}

									if($sql5['friend_type'] == "user")
									{
										$friendQuery  = mysql_query("SELECT `id`,`profilename`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
															FROM `mysittid_latest`.`user` 
															WHERE `id` = '$sql5[friend_id]'
														");
										$friendResult = mysql_fetch_assoc($friendQuery);
									//	echo "<pre>"; print_r($friendResult); exit;
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
										$anchorPath = 'profile.php?id='.$friendID;

									}
									else
									{
										$friendQuery  = mysql_query("SELECT `id`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
															FROM `mysittid_latest`.`clubs` 
															WHERE `id` = '$sql5[friend_id]'
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
										$anchorPath = 'host_profile.php?host_id='.$friendID;
									}


									
									  
									//echo "<pre>"; print_r($sql5); exit;
									$countrysql = @mysql_query("SELECT * FROM `country` WHERE country_id = '$friendCountryid' ");
									$countryfetch = @mysql_fetch_array($countrysql);
									$statesql = @mysql_query("SELECT * FROM `zone` WHERE zone_id = '$friendStateid' ");
									$statefetch = @mysql_fetch_array($statesql);
									$citysql = @mysql_query("SELECT * FROM `capital_city` WHERE city_id = '$friendCityid' ");
									$cityfetch = @mysql_fetch_array($citysql);

									if(trim($friendName) != "")
									{
										//echo "<pre>"; print_r($sql5); exit;

									?>		<tr <?php echo $class;?>>
												<td><input type="checkbox" name="friendsArray[]" class="others" value="<?php echo $sql5['f_id']; ?>" /></td>
												<td><?php echo $friendName ; ?></td>
												<td>
												<?php 
													if(!empty($imageSrc))
												 	{
									?>					<a href="<?php echo $anchorPath; ?>">
															<img  height="50px" width="50px" src="<?php echo $imageSrc; ?>" alt="" />
														</a>
					 <?php 								} 
											 		else
											 		{
											?>		 	<a href="<?php echo $anchorPath; ?>">
													 		<img height="50px" width="50px" src="images/man4.jpg"  alt=""/>
													 	</a>
											<?php 		}	?>
												</td>
												<td><?php echo $statefetch['name'];?> </td>
												<td><?php echo $cityfetch['city_name'];?> </td>
												<td><?php echo $friendZip ;?> </td>
												<?php if($friendSattus != 0) { ?>
												
											   <!-- <td id="enablechat_<?php echo $sql5['f_id']; ?>">
														<?php if($sql5['chat'] == 0){ ?>
																<a style="font-size:12px;min-width: 66px; margin: 0px 1px; border:1px solid #3b3b3b;" class="button" id="change_<?php echo $sql5['f_id'];?>" href="javascript:void(0);" onclick="chatsetting('disable','<?php echo $sql5["friend_id"]?>','<?php echo $sql5["f_id"]?>');">Disable Chat</a>
																<?php }else{ ?>
																<a style="font-size:12px;min-width: 66px; margin: 0px 1px; border:1px solid #3b3b3b;" class="button"  id="change_<?php echo $sql5['f_id'];?>" href="javascript:void(0);" onclick="chatsetting('enable','<?php echo $sql5["friend_id"]?>','<?php echo $sql5["f_id"]?>');">Enable Chat</a>
														 <?php  }  ?>              
												</td>-->
												
												<td>
										<?php // if(isset($_SESSION['user_id'])){ ?>
									<?php  if($sql5['freindstatus'] == 'active'){ ?>
											Already Friends
											<?php }else{ ?>
											<a  class="button button_view accept" href="javascript:void(0);" onclick="requestAccept('<?php echo $sql5['f_id'];?>');">Accept</a>
									<?php } ?>
											   </td>
												
												<!-- <td>                 -->
													<!-- <a class="button button_view" href="<?php if($sql5['friend_type'] == 'user'){?>profile.php?id=<?php echo $sql5['friend_id']; }else{?>host_profile.php?host_id=<?php echo $sql5['friend_id']; }?>"> View Profile </a> -->
								
													
												<!-- </td> -->
												<?php  } else { ?>
												
													  <td>Not Friend Yet</td>
													   
													  <?php } ?>
											
											</tr>
												
												  <?php
										}
								  		$i++;
							   		}
							   		$s = $i;
							   		while($pendingres = mysql_fetch_assoc($Pendingsql))
							   		{
							   			//echo "<pre>"; print_r($pendingres); 
							   			if($s%2 == '0')
										{
											$class = " class='even' ";
										}
										else
										{
											$class = " class='odd' ";
										}

										if($pendingres['user_type'] == "user")
										{
											$friendQuery  = mysql_query("SELECT `id`,`profilename`,`first_name`,`image_nm`,`last_name`,`country`,`state`,`city`,`status`,`zipcode`
																FROM `mysittid_latest`.`user` 
																WHERE `id` = '$pendingres[user_id]'
															");
											$friendResult = mysql_fetch_assoc($friendQuery);
										//	echo "<pre>"; print_r($friendResult); exit;
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
											$anchorPath = 'profile.php?id='.$friendID;

										}
										else
										{
											$friendQuery  = mysql_query("SELECT `id`,`club_name`,`image_nm`,`club_country`,`club_state`,`club_city`,`status`,`zip_code`
																FROM `mysittid_latest`.`clubs` 
																WHERE `id` = '$pendingres[user_id]'
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
											$anchorPath = 'host_profile.php?host_id='.$friendID;
										}


										
										  
										//echo "<pre>"; print_r($sql5); exit;
										$countrysql = @mysql_query("SELECT * FROM `country` WHERE country_id = '$friendCountryid' ");
										$countryfetch = @mysql_fetch_array($countrysql);
										$statesql = @mysql_query("SELECT * FROM `zone` WHERE zone_id = '$friendStateid' ");
										$statefetch = @mysql_fetch_array($statesql);
										$citysql = @mysql_query("SELECT * FROM `capital_city` WHERE city_id = '$friendCityid' ");
										$cityfetch = @mysql_fetch_array($citysql);

										if(trim($friendName) != "")
										{
											//echo "<pre>"; print_r($sql5); exit;

										?>		<tr <?php echo $class;?>>
													<td><input type="checkbox" name="friendsArray[]" class="others" value="<?php echo $pendingres['f_id']; ?>" /></td>
													<td><?php echo $friendName ; ?></td>
													<td>
													<?php 
														if(!empty($imageSrc))
													 	{
										?>					<a href="<?php echo $anchorPath; ?>">
																<img  height="50px" width="50px" src="<?php echo $imageSrc; ?>" alt="" />
															</a>
						 <?php 								} 
												 		else
												 		{
												?>		 	<a href="<?php echo $anchorPath; ?>">
														 		<img height="50px" width="50px" src="images/man4.jpg"  alt=""/>
														 	</a>
												<?php 		}	?>
													</td>
													<td><?php echo $statefetch['name'];?> </td>
													<td><?php echo $cityfetch['city_name'];?> </td>
													<td><?php echo $friendZip ;?> </td>
													<?php if($friendSattus != 0) { ?>
													
												   <!-- <td id="enablechat_<?php echo $sql5['f_id']; ?>">
															<?php if($sql5['chat'] == 0){ ?>
																	<a style="font-size:12px;min-width: 66px; margin: 0px 1px; border:1px solid #3b3b3b;" class="button" id="change_<?php echo $sql5['f_id'];?>" href="javascript:void(0);" onclick="chatsetting('disable','<?php echo $sql5["friend_id"]?>','<?php echo $sql5["f_id"]?>');">Disable Chat</a>
																	<?php }else{ ?>
																	<a style="font-size:12px;min-width: 66px; margin: 0px 1px; border:1px solid #3b3b3b;" class="button"  id="change_<?php echo $sql5['f_id'];?>" href="javascript:void(0);" onclick="chatsetting('enable','<?php echo $sql5["friend_id"]?>','<?php echo $sql5["f_id"]?>');">Enable Chat</a>
															 <?php  }  ?>              
													</td>-->
													
													<td>
											<?php // if(isset($_SESSION['user_id'])){ ?>
										<?php  if($pendingres['freindstatus'] == 'active'){ ?>
												Already Friends
												<?php }else{ ?>
												<a  class="button button_view accept" href="javascript:void(0);" onclick="requestAccept('<?php echo $pendingres['f_id'];?>');">Accept</a>
										<?php } ?>
												   </td>
													
													<!-- <td>                 -->
														<!-- <a class="button button_view" href="<?php if($sql5['friend_type'] == 'user'){?>profile.php?id=<?php echo $sql5['friend_id']; }else{?>host_profile.php?host_id=<?php echo $sql5['friend_id']; }?>"> View Profile </a> -->
										<?php //	} 	?>
														
													<!-- </td> -->
													<?php  } //else { ?>
													
														  <!-- <td><a href="non_member_edit_profile.php?non_member=<?php echo $pendingres['user_id'];?>">
													<img width="25px" height="25px" title="Edit" src="images/Edit.png"></a>
														  <a onclick="return confirm('Are you sure you want to delete?')" href="?page=del&id=<?php echo $pendingres['user_id'];?>">
													<img width="25px" height="25px" title="Delete" src="images/del.png"></a></td> -->
														   
														  <?php //} ?>
												
												</tr>
													
													  <?php
											}
									  		$s++;
									  		
							   		}
												   
								
									?>
					</tbody>
					</table>
					</form>
												 
										</div>
										<? } ?>
					  </div>
				</div>
			</div>
		</article>
	</div>
</div>


<?php include('Footer.php') ?>

