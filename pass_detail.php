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
						$get_passes = @mysql_query("SELECT * FROM host_coupon WHERE host_id='".$_SESSION['user_id']."' AND id='".$_GET['p_id']."'");
						$count_passes = mysql_num_rows($get_passes);
						$get_pass_name = mysql_fetch_assoc($get_passes);
					?>
						<div id="profile_box">
							<h3 id="title" class="">Pass : <?php echo $get_pass_name['coupon_name']; ?></h3>
					<?php
							$check_export = @mysql_query("SELECT redeem_date,user_id FROM downloadpasses WHERE host_id='".$_SESSION['user_id']."' AND pass_id='".$_GET['p_id']."' AND status='1'");
							$count_export_check = mysql_num_rows($check_export);
							if($count_export_check > 0)
							{
								echo '<a style="float:right" class="button" href="download_pass_report.php?p_id='.$_GET['p_id'].'&u_id='.$_SESSION['user_id'].'&p_name='.$get_pass_name['coupon_name'].'">Export To Excel</a>';
							} 
					?>
						</div>
						<div class="autoscroll">
							<table id="example" class="display loadmusic host_cp_table" style="margin-top:10px;">
								<thead>
									<tr bgcolor="#ACD6FE">
										<th>Pass Name</th>
										<th>User Name</th>
										<th>Pass Redeem Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
							<?php 
								if($count_passes < 1)
								{ 
							?>		<tr>
										<td colspan="4">
											No pass Found
										</td>
									</tr>
						<?php 		}
								else
								{
									$get_redeems = @mysql_query("SELECT redeem_date,user_id FROM downloadpasses WHERE host_id='".$_SESSION['user_id']."' AND pass_id='".$_GET['p_id']."' AND status='1'");
									$count_Redeems = mysql_num_rows($get_redeems);
									if($count_Redeems < 1)
									{
						?>				<tr>
											<td colspan="4">
											Pass not redeemed by any user yet
											</td>
										</tr>												
							<?php 		}
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
											$get_userdata = mysql_query("SELECT first_name, last_name, profilename FROM user WHERE id = '".$row['user_id']."'");
											$get_u_data = mysql_fetch_assoc($get_userdata);
							?>
											<tr <?php echo $class;?>>
												<td><?php echo $get_pass_name['coupon_name']; ?></td>
											<?php 
												if(empty($get_u_data['profilename']))
												{ 
													echo '<td>'.$get_u_data['first_name'].$get_u_data['last_name'].'</td>';
												}
												else
												{
													echo '<td>'.$get_u_data['profilename'].'</td>';
												} 
											?>
												<td><?php echo date('F j, Y l h:i:s A', strtotime($row['redeem_date'])); ?></td>
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

<?php include('Footer.php'); ?>