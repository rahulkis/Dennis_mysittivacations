<?php
include("Query.Inc.php");
$Obj = new Query($DBName);

if(!isset($_SESSION['user_id'])){
	$Obj->Redirect("login.php");
}

if($_SESSION['user_type'] == "user"){
	$Obj->Redirect("profile.php");
}

if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql) ;
$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}
		
$sql_fe=mysql_query("select * from  host_coupon where host_id='".$_SESSION['user_id']."'");
$rw_row_fe=@mysql_fetch_assoc($sql_fe);
$titleofpage="Pass Detail";

if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
}

$userID = $_SESSION['user_id'];
/******************/
$userType= $_SESSION['user_type'];
?>
<style>
	#couponupload_toggle{
		display: none;
	}
</style>		
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('club-right-panel.php'); ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
				<?php
					$get_passes = @mysql_query("SELECT * FROM paid_passes WHERE host_id='".$_SESSION['user_id']."' AND pass_id='".$_GET['p_id']."'");
					$count_passes = mysql_num_rows($get_passes);
					$get_pass_name = mysql_fetch_assoc($get_passes);
					
					$event_nm = mysql_query("SELECT eventname FROM events WHERE id = '".$get_pass_name['event_id']."'");
					$check_event_exists = mysql_num_rows($event_nm);
					$event_name = mysql_fetch_assoc($event_nm);
				?>
						<div id="profile_box">
							<h3 id="title" class="">Event Name : <?php echo $event_name['eventname']; ?></h3>
									
				<?php
						$check_export = @mysql_query("SELECT redeem_date,user_id FROM downloadpasses WHERE host_id='".$_SESSION['user_id']."' AND pass_id='".$_GET['p_id']."' AND status='1'");
						$count_export_check = mysql_num_rows($check_export);
						if($count_export_check > 0)
						{
							echo '<a style="float:right" class="button" href="download_pass_report.php?p_id='.$_GET['p_id'].'&u_id='.$_SESSION['user_id'].'&p_name='.$get_pass_name['coupon_name'].'">Export To Excel</a>';
						} 
						if(isset($_GET['host_id']))
						{
							echo '<a style="float:right" class="button" href="paid-tickets.php?host_id='.$_GET['host_id'].'">Back</a>';
						}
						else
						{
							echo '<a style="float:right" class="button" href="paid-tickets.php">Back</a>';	
						}
						
				?>	
						</div>
						<div class="autoscroll" tabindex="5000">
							<table id="example" class="display loadmusic host_cp_table" style="margin-top:10px;">
								<thead>
									<tr bgcolor="#ACD6FE">
										<!--<th>Pass Name</th>-->
										<th>User</th>
										<th>Ticket Redeem Status</th>
										<th>Ticket Redeem Date</th>
										<th>Barcode</th>
										<th>Security Code</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								if($count_passes < 1)
								{ 
								?>	<tr>
										<td align="center" style="text-align:center !important" colspan="6">
											No pass Found
										</td>
									</tr>
						<?php 		}
								else
								{
									$get_redeems = mysql_query("SELECT * FROM paid_pass_download WHERE host_id='".$_SESSION['user_id']."' AND pass_id='".$_GET['p_id']."'");
									$count_Redeems = mysql_num_rows($get_redeems);
									if($count_Redeems < 1)
									{ 
						?>
										<tr>
											<td colspan="6">
												Pass not redeemed by any user yet
											</td>
										</tr>												
						<?php 			}
									else
									{
										$i=1;
										while($row = mysql_fetch_assoc($get_redeems))
										{
											if($i%2 == '0')
											{
												$class = " class='even' ";
											}
											else
											{
												$class = " class='odd' ";
											}												
											if($row['transferred_to'] != 0)
											{
												$row['user_id'] = $row['transferred_to'];											
											}
											$get_userdata = mysql_query("SELECT email, first_name, last_name, profilename FROM user WHERE id = '".$row['user_id']."'");
											$get_u_data = mysql_fetch_assoc($get_userdata);
							?>
											<tr <?php echo $class;?>>
												<td><?php echo $get_u_data['email']; ?></td>
												<td><?php echo ucfirst($row['status']); ?></td>
												<td><?php if($row['status'] == 'pending'){ echo "Not redeemed yet"; }else{ echo date('F j, Y l h:i:s A', strtotime($row['redeem_date'])); } ?></td>
												<td>
													<a href="javascript:void(0);" onclick="popupbarcode('<?php echo $row['pass_id']; ?>','<?php echo $_SESSION['user_id'];?>','<?php echo $row['user_id'];?>','<?php echo $row['pd_id']; ?>');">
														<img src="images/barcode_default.png" alt="Barcode" />
													</a>
												</td>
												<td><?php echo $get_pass_name['security_code']; ?></td>
												<td><a href="profile.php?id=<?php echo $row['user_id']; ?>">View</a></td>																	
											</tr>										
						<?php 					$i++; 
										}
									}
								} 
						?>
								</tbody>
							</table>
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
function popupbarcode(passid,hostid,userid,pdid)
{
	url = 'barcodeGet.php?host_id='+hostid+'&user_id='+userid+'&pass_id='+passid+'&pd_id='+pdid;
	var left = (screen.width/2)-(500/2);
	var top = (screen.height/2)-(300/2);

	window.open(url,'1396358792239','width=500,height=520,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left='+left+',top='+top);
	return false;
	
}
</script>	
<?php include('Footer.php'); ?>