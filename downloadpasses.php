<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("index.php");
	die;
}
$titleofpage="Downloaded Passes";
include('NewHeadeHost.php');

$first_name=$loggedin_user_data['first_name']; 
$last_name=$loggedin_user_data['last_name'];
$zipcode=$loggedin_user_data['zipcode'];
$state=$loggedin_user_data['state'];
$country=$loggedin_user_data['country'];
if($loggedin_user_data['DOB']==''){$dob="00/00/0000";} else $dob=$loggedin_user_data['DOB'];
$city=$loggedin_user_data['city'];
$email=$loggedin_user_data['email'];
$image_nm=$loggedin_user_data['image_nm'];
$phone=$loggedin_user_data['phone'];
/**********************************/

if(isset($_SESSION['success']))
{
	$success=$_SESSION['success'];
	unset($_SESSION['success']);
}

?>

	
<SCRIPT language="javascript">
$(function(){
 $('#selectall').click(function() {
		if ($('#selectall').is(':checked')) {
			$('.others').attr('checked', true);
		} else {
			$('.others').attr('checked', false);
		}
	});
});


function delrecoreds(id)
{
  	if(confirm('Are You sure You want to delete this record'))
	{
	 	$.get( "deleteshout.php?id="+id, function( data ) {
	 	//alert('adadadada');
			window.location='user_shout.php';
		});
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
	}
}
</SCRIPT>

<script type="text/javascript">
  function popupwindow(url, title, w, h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=500, height=600, top='+top+', left='+left);
  }
</script>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php   
                    	if(!isset($_GET['id']))
                    	{
                    		include('friend-right-panel.php');
                     	}
                     	else 
         		{
         			include('friend-profile-panel.php');
                       	} 
           	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<h3 id="title" class="botmbordr">Downloaded Passes</h3> 
						<div id="middle" style="" >
						<?php
							$gettrackquery = @mysql_query("SELECT * FROM `downloadpasses` as `dp`, `host_coupon` as `hp`, `clubs` as `cl` WHERE `dp`.`user_id` = '".$_SESSION['user_id']."' AND `dp`.`pass_id` = `hp`.`id` AND `hp`.`host_id` = `cl`.`id` AND `dp`.`status` = '0' ORDER BY `hp`.`expiry_date` DESC");
							$counttracklist = @mysql_num_rows($gettrackquery);
							if($counttracklist > 9)
							{
								$class = " class=' '";
							}
						?>
						 	<div <?php echo $class;?>>
						<?php 
							if(isset($_SESSION['pass_redeemed']))
							{ 
						?>
							 	<div id="error" class="successmessage" style=""><?php echo $_SESSION['pass_redeemed']; unset($_SESSION['pass_redeemed']); ?></div>  
					 <?php 		}
						 	if($_GET['msg'] == "deleted")
				 			{ 
				 	?>
							   	<div id="error" class="successmessage" style="">Pass Deleted Successfully</div> 
					 <?php 		}	 ?>
								<div class="autoscroll">
									<table  class="display" id="example" style="margin-top:10px; background:#fff;" >
										<thead>
											<tr style="background-color:rgb(254, 205, 7); line-height:34px">
									    		<th width="20%">Club Name</th>
												<th width="20%">Pass Name</th>
												<th width="15%">Pass</th>
												<th width="15%">Expiry Date</th>
												<th width="15%">Status</th>
												<th width="15%">Action</th>
											</tr>
										</thead>
										<tbody>
								<?php
										$i=0;
										if($counttracklist > 0) 
										{
											while($row1 = mysql_fetch_array( $gettrackquery))
											{ 
												if($row1['pass_id'])
												{
							             ?>
								                				<tr <?php if($i%2==0){?> class="odd" <?php } ?>>
									                				<td>
									                					<?php echo $row1['club_name'];?>
									                				</td>
														<td>
															<?php echo $row1['coupon_name'];?>
														</td>
									                				<td>
															<a href="javascript:void(0);" onclick= "popupwindow('redeem_pass.php?pass_id=<?php echo $row1['pass_id']; ?>', 'Redeem Pass', '500', '650');"><img width="100" src="<?php echo $row1['coupon_thumb']; ?>"></a>
									                				</td>
														<td>
															<?php echo date('F j, Y l h:i:s A', strtotime($row1['expiry_date'])); ?>
														</td>
														<td>
													 <?php
													 		$date1 = date("Y-m-d");
													 		$ts1 = strtotime($date1);
													 		$ts2 = strtotime($row1['expiry_date']);
													 		$seconds_diff = $ts2 - $ts1;												 
													 		if($seconds_diff < 0){ echo "Expired"; }else{ echo "Active"; }
													 ?>					 
														</td>
														<td>
													 <?php
													 		$date1 = date("Y-m-d");
													 		$ts1 = strtotime($date1);
													 		$ts2 = strtotime($row1['expiry_date']);												 
													 		$seconds_diff = $ts2 - $ts1;												 
													 		if($seconds_diff < 0)
												 			{ 
												 	?>
																<a href="javascript: void(0)" onclick="delete_pass('<?php echo $row1['host_id']; ?>', '<?php echo $row1['user_id']; ?>', '<?php echo $row1['pass_id']; ?>')"><img src="images/del.png" width="25px" title="Delete" height="25px"></a>
													 <?php 		} 	?>					 
														</td>					
								                				</tr>
										<?php
												}
												$i++;
											} 
										}
										else 
										{ 
									?>
								        					<tr class="odd">
								        						<td colspan="6" align="center">No Pass Found</td>
								        					</tr>
								        <?php 	} 	?>
										</tbody>
									</table>
								</div>
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

<script>

function delete_pass(host_id, user_id, pass_id){

   var r = confirm("Are you sure want to delete pass ?");
   if (r == true) {
	   jQuery.post('ajaxcall.php', {
		 'delete_pass': 'delete_pass',
		 'host_id': host_id,
		 'user_id': user_id,
		 'pass_id': pass_id
		 }, function(response){
			if (response == "deleted") {
			  window.location.href = "downloadpasses.php?msg=deleted";
			}
		 });
   }else{
	  return false;
   }
}
</script>
<?php include('Footer.php') ?>