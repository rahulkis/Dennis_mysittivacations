<?php

include("Query.Inc.php");

$Obj = new Query($DBName);

$hostID=$_GET['host_id'];

$userType= $_SESSION['user_type'];

if(isset($_SESSION['user_id']) && $_SESSION['user_type']=='club')

{

	$sql="SELECT * FROM `contest` where `status`='1' AND host_id=".$_SESSION['user_id']."   ORDER BY `contest_id` ";	

	$contests_list = mysql_query($sql);

}

else

{

	$Obj->Redirect("login.php");

}

?>

<style type="text/css" title="currentStyle">

	@import "css/demo_page.css";

	@import "css/demo_table.css";

</style>

<?php

$titleofpage="Host Contest";	

if(isset($_GET['host_id']))

{

	include('NewHeadeHost.php');

}

else

{

	include('NewHeadeHost.php');	

}

?> 

<script type="text/javascript">

function deletecon(id)

{

	if(confirm('Are you sure you want delete this contests'))

	{

		$.get( "deletecontests.php?id="+id, function( data )

	 	{

			window.location='contests_list.php?id='+id;

   		});

	}

}



$(document).ready(function(){

	$('input[type="radio"]').click(function(){

		if($(this).val() == "Disable with message")

		{

			$('#disablemessage').css('display','block');

		}

		else

		{

			$('#disablemessage').css('display','none');

		}

	});

});

</script>

<?php 

if(isset($_POST['savesetting']))

{

	$value = $_POST['function'];

	if($value == "Disable with message")

	{

		$m = $_POST['contestmessage'];

	}

	else

	{

		$m = "";

	}

	$getq1 = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_SESSION['user_id']."'  ");

	$countrec1 = @mysql_num_rows($getq1);

	if($countrec1 > 0)

	{

		@mysql_query("UPDATE `host_functions_setting` SET `contest` = '$value', `contestmessage` = '$m' WHERE `host_id` = '".$userID."'  ");

	}

	else

	{

		@mysql_query("INSERT INTO `host_functions_setting` (`host_id`,`contest`,`contestmessage`) VALUES ('".$userID."','$value','$m')  ")	;

	}

	$message = "Contest Display Settings is Saved.";

}

?>

<div class="clear"></div>

<div class="v2_container">

	<div class="v2_inner_main">

	<!-- SIDEBAR CODE  -->

	<?php include('club-right-panel.php');?>

	<!-- END SIDEBAR CODE -->

		<article class="forum_content v2_contentbar">

			<div class="v2_rotate_neg">

				<div class="v2_rotate_pos">

					<div class="v2_inner_main_content">

  						<div class="title  botmbordr" id="title"><h3 id="title"> Contest </h3>

				                		<span class="disableall">

				     				<a href="addcontest.php?type=host_add" class="button" style="float: right;">Add Contest</a>

				     			</span>

				           		</div>

					<?php 

						if($message!="")

						{

					   		echo '<div id="successmessage" class="message" >'.$message.'</div>';

						}

						if(isset($_GET['msg']))

						{

							echo '<div id="successmessage" class="message" >Contest successfully added</div>';

						}

						$pieces = explode(" ", $username);

						$username_dash_separated = implode("-", $pieces);

	?>	      			<!-- Start Host Information-->
		<div class="contest-banner">
							<img src="images/contest-banner.png" alt="banner">
							<h3>Contest</h3>
							<p>
								The best way to strengthen your fan relationship and build loyal following is by having contests. We have made it simple to set up. MySitti will also track the contestants and notify you of the winner.
							</p>
							</div>

			           			<div class="autoscroll">

			           				<form name="shout_frm" id="shout_frm" method="post">

								<table  class="display" id="example" style="margin-top:10px;" >

									<thead>

										<tr bgcolor="#CCCCCC">

											<th width="120">Title</th>

											<th>Contest Start 	</th>

											<th>Contest End</th>

											<th>Action</th>

										</tr>

									</thead>

									<tbody>

					<?php				$i=0;

									if($num=@mysql_num_rows($contests_list))

									{

										while($row1 = mysql_fetch_array($contests_list))

										{

					?>						<tr <?php if($i%2==0){?> class="odd" <?php } ?>>

												<td><?php echo $row1['contest_title']; ?></td>

												<td>

													<?php echo  date('F jS  Y',strtotime($row1['contest_start'])); ?>

												</td>

												<td>

													<?php echo  date('F jS  Y',strtotime($row1['contest_end'])); ?>

												</td>

												<td>

													<a href="view_contestent.php?cont_id=<?php echo $row1['contest_id']; ?>&hostID=<?php echo $_SESSION['user_id']; ?>">View</a> | 

													<a href="addcontest.php?type=host_add&cont_id=<?php echo $row1['contest_id']; ?>&hostID=<?php echo $_SESSION['user_id']; ?>">Edit</a> | 

													<a href="javascript:void(0);" onclick="deletecon('<?php echo $row1['contest_id']; ?>');">Delete</a>

												</td>

											</tr>

					<?php						$i++;

										} 

										}

										else

										{

							 ?>

											<tr>

												<td colspan="4" align="center">No Contests Add Yet</td>

											</tr>



								<?php		}	?>

									</tbody>

								</table>

							</form>

		          				</div><!-- END DIV SCROLL -->

			          			<div class="storefunctionsetting">

							<h5>Contest Page Display Settings: </h5>

					<?php 

							$getq = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$userID."'  ");

							$countrec = @mysql_num_rows($getq);

							if($countrec > 0)

							{

								$fetchstatus = @mysql_fetch_array($getq);

								$statuspage = $fetchstatus['contest'];

								$me = $fetchstatus['contestmessage'];

							}

							else

							{

								$statuspage = "Enable";

								$me= "";

							}

					?>

							<form method="POST" action="" name="storesettings" id="storesettingsform" >

								<div><input <?php if($statuspage == "Enable"){ echo "checked"; } ?> type="radio" name="function" value="Enable" />Enable</div>

								<div><input <?php if($statuspage == "Disable with message"){ echo "checked"; } ?> type="radio" name="function" value="Disable with message" id="disbleshow" />Disable with message</div>

								<div id="disablemessage" style="display: none;"><input type="text" name="contestmessage" value="<?php echo $me;?>" /></div>

								<div><input <?php if($statuspage == "Disable without message"){ echo "checked"; } ?> type="radio" name="function" value="Disable without message" />Disable And Hide</div>

								<div class="settingformsubmit"><input type="submit" class="button" name="savesetting" value="Save" /></div>

							</form>

						</div>

  					</div>

  				</div>

			</div>

			<div class="equalizer"></div>

		</article>

	</div>

	<div class="clear"></div>

</div>

<?php include('Footer.php');?>







