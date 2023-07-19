<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
}


if(isset($_POST['saverequest']))
{
	
	$stat = trim($_POST['status']);
	if($stat == "")
	{
		$stat = "0";
	}
	$query = mysql_query("UPDATE clubs SET musicrequeststatus = '$stat' WHERE id= '$userID' ");

	if($stat == '1')
	{
		
		$message = '<div  id="successmessage" class="message"> Music Requests are now disabled.</div>';
	}
	else
	{
		$message = '<div  id="successmessage" class="message"> Music Requests are now enabled.</div>';
		//$message = "Music Request List is Disabled for users.";
	}
	
}

if(isset($_POST['statusupdate']))
{
	$message = '<div  id="successmessage" class="message">Request status updated successfully.</div>';
	
}
$titleofpage=" Music Request List";

if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
}

?> 
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
<?php
 	if(isset($_SESSION['subuser']))
	{
		include('sub-right-panel.php');	
	}
	else
	{
		if((isset($_GET['uid'])) && ($_SESSION['user_type'] == 'user') )
		{
			include('sub-right-panel.php');	
		}
		else
		{
			include('club-right-panel.php');		
		}
		
	}
?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<?
					if(isset($_GET['uid']) && ($_GET['uid'] != ''))
					{
						$userID = $_GET['uid'];
					}
					else
					{
						$userID = $userID;	
					}
				  	$checkquery = mysql_query("SELECT musicrequeststatus FROM clubs WHERE id='$userID' ");
					$checkresult = mysql_fetch_array($checkquery);
					echo  "<h3 id='title'>Music Request</h3>";
				
					if(isset($_GET['status'] ) && !empty($_GET['status']) && $_GET['status'] == 'update')
					{
								$message="Request status updated successfully.";
								 
					}
					if(isset($message))
					{
						echo $message;
				      	}
				?>
							<div class="requestform">
								<a href="/musicrequestList.php" class="button">Request List</a>
							</div>
						<?php if($checkresult['musicrequeststatus'] == "1"){ 
								$class1 ='style="float: left;display:none;"';
								//echo '<h2 style="margin-left:146px;margin-top:120px;font-family:Arial,Helvetica,sans-serif;font-size:24px;">Music request listing is disable.</h2>';
							} else {
								$class1 ='style="float: left;display:block;"';
							}
						?>

						<div class="musiclisting" <?php echo $class1; ?>>
						 
						 	<?php 
						 	
						$result = mysql_query("SELECT * FROM jukeboxplaylist WHERE playlist_id = '".$_GET['listid']."' ORDER BY `status` ASC ");
						$i=1;
						$class="";
						$count = mysql_numrows($result);
						if($count > 12)
						{
							$class=" class=' '";
						}
						else
						{
							$class=" class=autoscroll";
						}
						echo "<div ".$class." ><table class='display loadmusic' id='example' style='margin-top:10px;' >";
						echo "<thead><tr bgcolor='#ACD6FE'>
						<th>Status</th>
						<th>Music</th>
						<th>Artist</th>
						<th>Note</th>
						<th>Profile Name</th>
						<th>City,State</th>
						<th>Request Time</th>
						</tr></thead>";
						echo "<tbody>";
						if( $count > 0)
						{
							
						while($row = mysql_fetch_array( $result ))
						{
						//echo '<pre>';print_r($row);

							$getuserinfo = @mysql_query("SELECT * FROM `user` WHERE `id` = '".$row['user_id']."' ");
							$fetchuserinfo = @mysql_fetch_array($getuserinfo);
							$usercityquery = @mysql_query("SELECT * FROM `capital_city` WHERE `city_id` = '".$fetchuserinfo['city']."' ");
							$fetchusercity = @mysql_fetch_array($usercityquery);
							$userstatequery = @mysql_query("SELECT * FROM `zone` WHERE `zone_id` = '".$fetchuserinfo['state']."' ");
							$fetchuserstate = @mysql_fetch_array($userstatequery);


						if($i%2 == '0')
						{
							$class = " class='even' ";
						}
						else
						{
							$class = " class='odd' ";
						}

						echo '<tr '.$class.'>';





						if($_SESSION['user_type'] == 'user')
						{
							if($row['status'] == "")
							{
								echo "<td>Pending</td>";
							}
							else
							{
								if($row['status'] == 0)
								{
									echo "<td>Pending</td>";
								}
								elseif($row['status'] == 1)
								{
									echo "<td>Accept</td>";
								}
								else
								{
									echo "<td>Played</td>";
								}
									
							}
							
						}
						else
						{


							if($row['status'] == '1'){
								
								$row_status = '<option value="1" id="'.$row['id'].'">Accept</option>
										<option value="0" id="'.$row['id'].'">Pending</option>
										<option value="2" id="'.$row['id'].'">Played</option>';
										
										
							} elseif($row['status'] == '0') { //echo $row['status'];die('--------------------');
								$row_status = '<option value="0" id="'.$row['id'].'">Pending</option>
										<option value="1" id="'.$row['id'].'">Accept</option>
										<option value="2" id="'.$row['id'].'">Played</option>';
										
							} elseif($row['status'] == '2') { //echo $row['status'];die('--------------------');
								$row_status = '<option value="2" id="'.$row['id'].'">Played</option>
										<option value="1" id="'.$row['id'].'">Accept</option>
										<option value="0" id="'.$row['id'].'">Pending</option>';
										
							}
							else
							{
								$row_status = '<option value="0" id="'.$row['id'].'">Pending</option>
												<option value="1" id="'.$row['id'].'">Accept</option>			
										<option value="2" id="'.$row['id'].'">Played</option>';
							} 
							//echo $row_status;die;
							echo '<td><select class="test" id="status_list'.$i.'">'.$row_status. '</select></td>';

						}
						echo '<td>' . $row['music_title'] . '</td>';
						echo '<td>' . $row['artist'] . '</td>';
						echo '<td class="note">' . substr($row['special_note'],0,20) . '<p id="hint'.$i.'"  style="display:none;"> ' . $row['special_note'] . '</p></td>';
						echo '<td>' . $fetchuserinfo['first_name'].' '.$fetchuserinfo['last_name'] . '</td>';
						if(empty($fetchusercity['city_name'])){
								
								echo '<td>' . $fetchuserstate['name'] . '</td>';
							
						}elseif(empty($fetchuserstate['name'])){
							
							echo '<td>' . $fetchusercity['city_name'] . '</td>';
								
						}elseif(empty($fetchusercity['city_name']) && empty($fetchuserstate['name'])){
							
							echo "<td> Not Available </td>";
							
						}else{
							
							echo '<td>' . $fetchusercity['city_name'].",".$fetchuserstate['name'] . '</td>';
							
						}
						echo '<td>'. date("H:i:s",strtotime($row['added'])) .'</td>';
						echo "</tr>";
						$i++;
						}
						}
						else
						{
							echo "<tr class='odd' >";
							echo "<td colspan='6'> No requests made for this host.</td>";
						}
						echo "</tbody></table></div>";
						 	
						 	
						 	?>
						 
						 </div>
						<script>
						$(document).ready(function(){ 
						  		$('.test').change(function(){ 
						  		var loc = '';		
								var id = $(this).attr("id");
								var selected_text = $('#'+id).children(":selected").text();
								var selected_text1 = $('#'+id).children(":selected").attr('id');

								var selected_val = $('#'+id).val();
								var testval = $(this).val();
								$.ajax({
									url: "status_update.php",
									type: "POST",
									data: { testval: testval ,id : selected_text1 , text: selected_text},
									success:function(data){
										if(data == '2')
										{
											window.location = '/musicrequestList.php';
										}
										else
										{
											$('#hiddenform').submit();	
										}
										
									}
								});
									
								});
							});
								   
						</script>
						   
						   <form style="display: none;" method="POST" class="hiddenform" action="" id="hiddenform">
							<input type="hidden" name="statusupdate" value="123" />
							<input type="submit" name="statusupdate" value="submit" class="" />
						   </form>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php include('Footer.php');?>


