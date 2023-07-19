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
	if($para=="update")
	{
		$message="Shout added successfully";
	}
}

$titleofpage=" User Shouts";
include('NewHeadeHost.php');



$del_id = $_GET['id'];
if($del_id !="")
{
	$shoutsql ="DELETE FROM shouts WHERE shout_id = $del_id";
	mysql_query($shoutsql);
	$shoutsql ="DELETE FROM user_to_content WHERE cont_id = $del_id";
	mysql_query($shoutsql);  
	header('Location: my_shout.php');
}

if(count($_POST['shoutschk']) > 0)
{
		
	$ids=implode(",",$_POST['shoutschk']);
	mysql_query("delete from forum where shout_id IN(".$ids.")");
	$sql_del=mysql_query("delete from shouts where id IN(".$ids.")");
	if($sql_del)
	{	
		$_SESSION['success']="Shouts deleted successfully";
		header('location:user_shout.php?msg=deleted'); exit;
	}
}	
	
	
	$sql = "select * from `user` where `id` = '".$_SESSION['user_id']."'";
	$userArray = $Obj->select($sql) ; 
	$first_name=$userArray[0]['first_name']; 
	$last_name=$userArray[0]['last_name'];
	$zipcode=$userArray[0]['zipcode'];
	$state=$userArray[0]['state'];
	$country=$userArray[0]['country'];
	if($userArray[0]['DOB']==''){$dob="00/00/0000";} else $dob=$userArray[0]['DOB'];
	$city=$userArray[0]['city'];
	$email=$userArray[0]['email'];
	$image_nm=$userArray[0]['image_nm'];
	$phone=$userArray[0]['phone'];
	/**********************************/

	$sql1="select s.*,uc.is_read,uc.owner_id, uc.user_type from user_to_content as uc join  shouts as s on(s.id=uc.cont_id) where uc.user_id='".$_SESSION['user_id']."' AND uc.friend_type='$_SESSION[user_type]' AND cont_type='shout' group by uc.cont_id ORDER BY s.id DESC";
	$shout_list1 = mysql_query($sql1);

	$sql_pass = "SELECT * FROM user_to_content INNER JOIN host_coupon ON user_to_content.cont_id = host_coupon.id WHERE user_to_content.user_id = '".$_SESSION['user_id']."' AND user_to_content.cont_type = 'pass'";
	$shout_list_pass = mysql_query($sql_pass);

	$array_12 = array();
	$array_2 = array();

	while($p_row = mysql_fetch_assoc($shout_list_pass)){
	  
	  	$array_12[] = $p_row;
	  
	}	   
	while($s_row = mysql_fetch_assoc($shout_list1)){
	  
	 	$array_2[] = $s_row;
	  
	}

	// echo "<pre>"; print_r($array_2); exit;
	
	$current_date_check = date('Y-m-d H:i:s');
	$array_1 = array();
	foreach($array_12 as $array_123){

		if($array_123['expiry_date'] >= $current_date_check){
			
			$array_1[] = $array_123;
			
		}
		
	}

   	if(empty($array_1) && !empty($array_2))
	{
	   	$main_arr = $array_2;
	}
	elseif(empty($array_2) && !empty($array_1))
	{
		$main_arr = $array_1;
	}
	else
	{
			  
	 	function date_compare($a, $b)
		{
			$t1 = strtotime($a['added_date']);
			$t2 = strtotime($b['added_date']);
			return $t1 - $t2;
		}    
		$main_arr_first = array_merge($array_1,$array_2);
		usort($main_arr_first, 'date_compare');

		$main_arr = array_reverse($main_arr_first);

   	}
	

// echo "<pre>"; print_r($main_arr); echo "</pre>"; exit;

	$tot_shout_num=@mysql_num_rows($shout_list1);

		
	if(isset($_SESSION['success']))
	{
	  	$success=$_SESSION['success'];
	  	unset($_SESSION['success']);
	}

?>


<style>
.private_u_selected{
	float: left !important;
	width: 30%;
}
#example th {
  font-size: 13px;
  padding: 5px;
}
#clubs {
	float: left;
	margin-left: 10px;
	margin-top: 6px;
}	
.shout_notification {
	background: #fecd07 none repeat scroll 0 0;
	border: 1px solid #fecd07;
	border-radius: 100px;
	display: block;
	height: 40px;
	line-height: 40px;
	margin: 5px auto;
	padding: 4px;
	text-align: center;
	width: 40px;
}
table.display tr {
	background: #fff none repeat scroll 0 0;
	border-bottom: 1px solid #dbdbdb;
}
/*#example tr td:nth-child(2n) {
	background: #f2f2f2 none repeat scroll 0 0;
	padding-left: 5px;
}*/
table.display td {
	color: #000;
	padding: 7px 11px 7px 5px;
	text-align: center;
	text-shadow: none;
	vertical-align: middle;
	word-break: normal;
}

strong
{
	font-weight: bolder;
}
</style>

<script type="text/javascript">

function selectAll()
{
	
	if ($('#selectall').is(':checked')) {
		$('.others').attr('checked', true);
	} else {
		$('.others').attr('checked', false);
	}
}

function goto_url(url)
{
	window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=200, left=500, width=700, height=500");
	return false;
}
function delrecoreds(id)
{
  if(confirm('Are You sure You want to delete this record'))
  {
	 $.get( "deleteshout.php?id="+id, function( data ) {
		//alert('adadadada');
			window.location='user_shout.php';
		});
  }
   else
   {
	
	}

}
function deletecon_user(id)
{
	if(confirm('Are you sure you want remove this shout'))
	{
	$.get( "deletecontests.php?id="+id+'&type=friend&action=shout', function( data )
	 {
		window.location='user_shout.php';
   });
	}else
	{
		
	}

}
</script>

<?php
$get_groups = mysql_query("select g.group_name,g.id from  chat_users_groups as cgs 
    join chat_groups as g on(g.id=cgs.group_id) where g.create_by='".$userID."' group by g.id");

// echo "select u.profilename, u.first_name,u.last_name,u.email,u.id from friends as f 
//    join user as u on(u.id=f.friend_id) where f.user_id 	='".$userID."' group by f.friend_id"; exit;

$get_friends = mysql_query("select u.profilename, u.first_name,u.last_name,u.email,u.id from friends as f 
   join user as u on(u.id=f.friend_id) where f.status = 'active' AND f.friend_type = 'user' AND f.user_id	='".$userID."' group by f.friend_id");

$cval = array();
$ci = 0;
$get_clubs = mysql_query("SELECT * FROM friends WHERE user_id = '".$_SESSION['user_id']."' AND friend_type = 'club' AND status = 'active'");
?>

<script src="js/private-zone.js"></script>
<!-- <link type="text/css" rel="stylesheet" href="css/style_popup.css" />
<link rel="stylesheet" href="js/codejs/jquery-ui.css">
<script src="js/codejs/jquery-1.10.2.js"></script>
<script src="js/codejs/jquery-ui.js"></script> -->

<?php
while($rs = mysql_fetch_assoc($get_groups)) {
   $val[] = $rs['group_name'];
}

while($rs5 = mysql_fetch_assoc($get_friends)) {

	$val2[] = $rs5['profilename'];
}

while($c_row = mysql_fetch_assoc($get_clubs)){
	
	$get_c_res = mysql_query("SELECT id as club_id, club_email, club_name FROM clubs WHERE id = '".$c_row['friend_id']."'");
	
	while($cg_row = mysql_Fetch_assoc($get_c_res)){
		
		if(!empty($cg_row['club_name'])){
			$cval[] = $cg_row['club_name'];
		}
	}
	
}



$combineArray = array_merge($val,$val2,$cval);
$combineArray1 = array_unique($combineArray);
$lastArray = array();
foreach($combineArray1 as $val )
{
	$val = trim($val);
	if(!empty($val) && !in_array(needle, haystack))
	{
		$lastArray[] = $val;
	}
}



 // echo "<pre>"; print_r($lastArray); 

?>

<script type="text/javascript">
$(document).ready(function(){
	
	var group_list = new Array();
    
	group_list = <?php echo json_encode($lastArray); ?>;
// alert(group_list);
	$("#search_val").autocomplete(group_list, {
		multiple: true,
		mustMatch: true,
		autoFill: true
	});
	
	var friend_list = new Array();
    
	friend_list = <?php echo json_encode($val2); ?>;

	$("#search_val2").autocomplete(friend_list, {
		multiple: true,
		mustMatch: true,
		autoFill: true
	});
	
	var hot_spots_list = new Array();
    
	hot_spots_list = <?php echo json_encode($cval); ?>;

	$("#search_val3").autocomplete(hot_spots_list, {
		multiple: true,
		mustMatch: true,
		autoFill: true
	});		

});

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
	
	function clear_fields(){
		
		$('.clear_flds').val('');
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
	
	function selectFile()
	{
		document.getElementById("file").click();  
	} 
	
</script>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('friend-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  							<?php
								if(isset($_GET['msg'])){
									   if($_GET['msg'] == "update"){
											  
											$msg = "Shout Updated Successfully";
											  
									   }elseif($_GET['msg'] == "deleted"){
										
											$msg = "Shout Deleted Successfully";
										
									   }elseif($_GET['msg'] == "added"){
										
											$msg = "Shout Added Successfully";
										
									   }
								}
								?>
								<?php if(isset($msg)) { ?> <div class="successmessage" ><?php echo $msg; ?></div> <?php } ?>
								<?php if(isset($_SESSION['user_p_ass_del'])) { ?> <div class="successmessage" ><?php echo "Pass Deleted SUccessfully"; ?></div> <?php unset($_SESSION['user_p_ass_del']); } ?>
								<?php if(isset($_SESSION['s_deleted'])) { ?> <div class="successmessage" ><?php echo "Shout Deleted Successfully"; ?></div> <?php unset($_SESSION['s_deleted']); } ?>
								   	<h3 id="title" class="botmbordr">Shouts page </h3>
										<div id="ad_profile_pst">
											<form class="popupform friend_search_form" name="forum" action="add_usershout.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" id="add_shoutt">
												<div class="ppost_newdesign">
													<div class="lbl">  
														<label >Send Shout Out</label>
														<div id="u_0_s" class="_6a _m">
															<a id="u_0_t" rel="ignore" role="button" aria-pressed="false" class="_9lb">
																<span class="uiIconText _51z7"><i class="img sp_6gM6z_J0XH8 sx_a8afaf">
																	<img src="images/upload_camera.png">
																	</i>Add Photo/Video<i class="_2wr"></i>
																</span>
																<div class="_3jk">
																	<input type="file" onchange="return ValidateFileUpload()" id="js_0" class="_n _5f0v" title="Choose a file to upload" name="shout_media" aria-label="Upload Photos/Video">
																	<!-- <input type="file" aria-label="Upload Photos/Video" name="forum_img" title="Choose a file to upload" class="_n _5f0v" id="js_0" onChange="return ValidateFileUpload()"> -->
																		<span style="display: none;" id="file_upload_successs"><img src="images/tick_green_small.png"></span>
																</div>
															</a>
														</div>
														<textarea id="add_post_text"  name="shout" class="txt_box clear_flds" /></textarea>
													</div>
											   		<div class="private_pub_btn">
														<div id="" class="pst_buttons">
															<div id="posting_type" class="public_new_btn">    
																<span class="pt_header pt_header1">Public</span>
														 		<div class="radiosn">
																	<div class="radioboxes_new">
																		<div>
																			<input type="radio" name="shout_type" checked="checked" value="public" onClick="javascript:$('#groups').hide();$('#friends').hide();$('#or').hide();$('.pt_header').html('Public');$('#clubs').hide();"  > <strong>Public </strong>
																			<p>Anyone Can See.</p>
																		</div>
																		<div>
																			<input name="shout_type"  value="private" onClick="javascript:$('#groups').show();$('#friends').show();$('#or').show();$('.pt_header').html('Private');$('#clubs').show();"   type="radio" > <strong>Private </strong>
																			<p>Only Friends and Selected Groups.</p>
																		</div>
																	</div>
																	<div style="clear:both"></div>
																</div>
															</div>										
															<input id="submit3" type="submit" name="submit" value="Post" class="button add_pub_p_post" style=""  />                    
														</div>
										   			</div>
												</div>
								                
								                
												<ul id="groups" class="private_u_selected pivate_frnds" style="display:none;">
													<li>
														<textarea cols="50" rows="5" name="search_val" id="search_val"></textarea>
														<input type="hidden" name="group" id="txt2">
														<p>Please type first few letters</p>
													</li>
												</ul>
											
												<!-- <ul id="friends" class="private_u_selected pivate_frnds" style="display:none;">
													<li></li>
													<li>
														<textarea placeholder="Send To Friends" cols="50" rows="5" id="search_val2" name="search_val2"></textarea>
														<input type="hidden" name="friend" id="txt_f">
														<p>Please type first few letters</p>
													</li>
												</ul>
												
												<ul id="clubs" class="private_u_selected pivate_frnds" style="display:none;">
													<li></li>
													<li>
														<textarea placeholder="Send To Hotspots" cols="50" rows="5" id="search_val3" name="search_val3"></textarea>
														<input type="hidden" name="clubs" id="txt_c">
														<p>Please type first few letters</p>
													</li>
												</ul> -->
										   	</form>
										</div>

									 
								<div id="middle">
								  <? if($tot_shout_num > 9)
									{
										$class = " class=''";
									}?>

										
								 <div <?php echo $class;?> style="margin-top:0px;" id="userShouts">
								 <form name="shout_frm" id="shout_frm" method="post">
								 
									 <div class="autoscroll">
									   
									   
								 
										<table  class="display" id="example">

									<thead>
										<tr style="background-color:rgb(254, 205, 7); line-height:34px">
											<th><INPUT TYPE=CHECKBOX NAME="all" onclick="selectAll();" id="selectall" width="100">
                      <a class="deletAll" href="javascript:void(0);" onclick="confirmdelete();"> Delete All</a></th>
											<th>Shout By</th>
											<th>Shouts</th>
											<th>Added Date</th>
											<th>Action</th>
											
										</tr>
									</thead>
									<tbody>
									<?php
									$i=0;
									
									if($main_arr) {
									//while($row1 = @mysql_fetch_array( $shout_list1))
									foreach($main_arr as $row1)
									{
									   // echo "<pre>";
									   // print_r($row1);
									   // echo "</pre>";
									   // die;
											 if($row1['user_type']=='club') 
											 {
										$sql_club=mysql_query("select * from clubs where id='".$row1['owner_id']."'");
										$club_dtl=@mysql_fetch_assoc($sql_club);
												$displayname = $club_dtl['club_name'];
												$displaypic = $club_dtl['image_nm'];
												$anchor = "host_profile.php?host_id=".$club_dtl['id'];
											 }
											 else
											 {
												$sql_club=mysql_query("select * from user where id='".$row1['owner_id']."'");
										$club_dtl=@mysql_fetch_assoc($sql_club);
												if($club_dtl['profilename'] == "")
												{
													$displayname = $club_dtl['first_name']." ".$club_dtl['last_name'];
													
												}
												else
												{
													$displayname = $club_dtl['profilename'];
												}
													$displaypic = $club_dtl['image_nm'];
													$anchor = "profile.php?id=".$club_dtl['id'];
											   
											 }
										   
										
										// if($row1['id'])
										// {
											
												 ?>
												<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
											  
											  <?php if ($row1['cont_type'] == "pass") { ?>
													 <td>PASS</td>
											  <?php }else{ ?>
													 <td><input type="checkbox" name="shoutschk[]" id="shoutschk" value="<?php echo $row1['id']; ?>" class="others"> </td>
											  <?php } ?>
												
												<td>
												
													
													<a href="<?php echo $anchor; ?>">

													<?php  if($displaypic!="") {?>

												  <img src="<?php echo $displaypic; ?>" width="50" height="50">
												  <?php }else { ?>
												   <img src="images/no_image.jpg" height="50" width="50">
												   <?php } ?><br>
												   
												   <?php echo $displayname; ?></a>
												   <?php //}
												?>
												   
												
												 </td>
												
												<?php if($row1['coupon_name'] != ""){ ?>
												
													<td>
													<p><?php echo $row1['coupon_name']; ?><p>
												   </td>					 
												
												<?php }else{ ?>
												
													<td>
													<p>
														
													<?php  // echo $_SESSION['user_id'].$row1['user_id'];
													if($row1['user_id']==$_SESSION['user_id']) {               
												   $sql_clubtotal=mysql_query("select count(cont_id) as cnt from user_to_content where cont_id='".$row1['id']."' AND user_id != '".$_SESSION['user_id']."' ");
												   $club_dtltotal=@mysql_fetch_assoc($sql_clubtotal);
												   $sql_clubread=mysql_query("select count(is_read) as cnt from user_to_content where cont_id='".$row1['id']."' and is_read=1");
												   $club_dtlread=@mysql_fetch_assoc($sql_clubread);
												   ?>
												   <span class="shout_notification">
												   <? echo  $club_dtlread['cnt']."/". $club_dtltotal['cnt'];?></span><? } ?>
												   
												   <?
													echo substr($row1['shout'],0,200); ?> <?php if(strlen($row1['shout']) > 50) { ?>....<?php } ?> <br>
													<?php if(strlen($row1['shout']) > 50) { ?>
													<a   href="javascript:void(0);"  onclick="goto_url('readshout.php?id=<?php echo $row1['id']; ?>')" style="color:red;">read more...</a>
													<?php } ?>
													
													<p>
												   </td>					 
												
												<?php } ?>
												
												   <td>
													<?php if($row1['added_date'] !="") { echo date('F jS  Y',strtotime($row1['added_date']));} ?>
												   </td>
												   
												   <?php if($row1['cont_type'] == "pass"){ ?>
												   
															<td>
																<a href="host_profile.php?host_id=<?php echo $row1['owner_id']; ?>">View Pass</a> |
																<a href="javascript: void(0);" onclick="delete_user_cpass('<?php echo $row1['cont_id'] ?>', '<?php echo $row1['user_id'] ?>', '<?php echo $row1['host_id'] ?>');">Delete Pass</a>
															</td>
												   
												   <?php }else{ ?>
												   
																   <td>
															   <?php if($_SESSION['user_id']!=$row1['user_id']){ ?>
															  <a href="javascript:void(0);"  onclick="goto_url('readshout.php?id=<?php echo $row1['id']; ?>')" >
															   <?php if($row1['is_read']=='1'){?>Read<?php }else{ ?>View <?php } ?>
															   </a>
															   <?php }else { ?>
															  <a href="edit_user_shout.php?shout_id=<?php echo $row1['id']; ?>"><img src="images/Edit.png" width="25px" ;="" height="25px"></a>
																<?php } ?>
											   
																  <?php  if(!isset($_GET['id']))
																  { ?> 
																	  <?php if($_SESSION['user_id']==$row1['user_id'])  { ?>
																				 
																			   <a href="javascript:void(0);" onClick="delrecoreds('<?php echo $row1['id']; ?>');"><img src="images/del.png" width="25px" ;="" height="25px"></a>
																				<?php  }else { ?>
																			   | <a href="javascript:void(0);" onClick="deletecon_user('<?php echo $row1['id']; ?>');">Delete</a> 
																				<?php } ?>
																				
																		   <? } ?>
																	</td>					 
												   
												   <?php } ?>
												</tr>
										<?php
										//}
										$i++;
										} }else { ?>
										<tr class="odd">
										<td colspan="5" align="center">No Shouts Found</td>
										</tr>
										<?php } ?>
									</tbody>
									
									</table>
								</div>
							</form>
							</div>
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
$( document ).ready(function() {
	$(".pt_header").click(function() {
		//$(".radioboxes_new").slideToggle();
		if($(".radiosn").css("display")!=="block"){
			$(".radiosn").show("fast");
			$(".pt_header").css("background-position","83% 6px");
			}
		else{
			$(".radiosn").hide("fast");
			$(".pt_header").css("background-position","83% -26px");
			}
	});

	$(".radioboxes_new input").click(function() {
		$(".radiosn").slideUp();
		 
		if($(".radiosn").css("display")!=="block"){
		$(".radiosn").show("fast");
		$(".pt_header").css("background-position","83% 6px");
		}
		else{
		$(".radiosn").hide("fast");
		$(".pt_header").css("background-position","83% -26px");
		}

		 
	});
		

});
</script>

<script type="text/javascript">
function ValidateFileUpload()
{
	var check_image_ext = $('#js_0').val().split('.').pop().toLowerCase();
	if($.inArray(check_image_ext, ['gif','png','jpg','jpeg', 'mov','m2ts','mp4','f4v','flv','webm','m4v']) == -1) {
		alert('Post Media only allows file types of GIF, PNG, JPG, JPEG, MOV, M2TS, MP4, WEBM, F4V, M4V and FLV');
		$('#js_0').val('');
	}else{
		$('#file_upload_successs').show();
	}
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

function addshout()
{
  if($('#shout').val()=="")
  {
	  $('#error_shout').html('Please enter your shout');
	   $('#error_shout').fadeOut(5000);
	  return false;
  }	else
  {
	  
   $('#shout_frm').submit();
 }
}
function Edit_shout()
{
  if($('#shout_edit').val()=="")
  {
	  $('#error_shout').html('Please enter your shout');
	   $('#error_shout').fadeOut(5000);
	  return false;
  }	else
  {
	  
   $('#shout_frm_edit').submit();
 }
}
function editshout(id)
{
	$.get("getshotdetails.php?id="+id, function( data ) {
		$('#shout_edit').val(data);
		//	window.location='shout.php';
		$("#shout_ac_edit" ).click();
		$("#edit_id" ).val(id);
		});	
}

function confirmdelete()
{
	if ($("#shout_frm input:checkbox:checked").length > 0)
	{
		// any one is checked
			var test = confirm('Are you sure you want delete selected records?');
		if(test == true)
		{
			$('#shout_frm').submit();
		}
	}
	else
	{
	   // none is checked
		alert('Please select atleast one record!');
		return false;
	}
	
}

function delete_user_cpass(cont_id, user_id, host_id){
	
		var r = confirm("Are you sure want to delete !");
		
		if (r == true) {
			var pass_id = cont_id;
			var user_id = user_id;
			var host_id = host_id;
			
			jQuery.post('ajaxcall.php', {'upass_id': pass_id, 'user_id': user_id, 'host_id': host_id}, function(response){
				
				window.top.location = "";	
				
			});
		}
}

function validateForm(){

var shout_type = $('input[name=shout_type]:checked', '#add_shoutt').val();
 
 if (shout_type == 'private') {
  if ($('#search_val').val() == '' && $('#search_val2').val() == '' && $('#search_val3').val() == '') {
   alert('Please select groups or friends or hotspots');
   return false;
  }
 }
}
</script>
<?php include('Footer.php') ?>
