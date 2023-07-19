<?php 
include("Query.Inc.php");
$Obj = new Query($DBName);
$titleofpage = "Electronic Press Kit (EPK)";

if(!isset($_SESSION['user_id']))
{
	include('PublicProfileHeader.php');
}
else
{
	if(isset($_GET['host_id']))
	{
		include('LoginHeader.php');
	}
	else
	{
		include('NewHeadeHost.php');	
	}
}

if(isset($_GET['host_id']))
{
	$userID=$_GET['host_id'];
}
else
{
	$userID=$_SESSION['user_id'];
}

$userType= $_SESSION['user_type'];

if($userType=='club'){
$userOrhost=" AND host_id ='$userID'";
$sql = "select * from `clubs` where `id` = '".$userID."'";
$userArray = $Obj->select($sql);

if($userType=="club" && $userArray[0][type_of_club]!=11){
//$Obj->Redirect("home_club.php");
}
$type_of_user="club";
}else if($userType=='user'){
if(!isset($_GET['host_id'])){
//$Obj->Redirect("index.php");
}
$type_of_user="user";
$hostID=$_GET['host_id'];
$userOrhost=" AND host_id ='$hostID'";
$sql = "select * from `clubs` where `id` = '".$hostID."'";
$userArray = $Obj->select($sql) ;
$type_of_club =$userArray[0]['type_of_club'];
if($userType=="user" && $type_of_club!=11){
//$Obj->Redirect("host_profile.php?host_id=".$hostID);
}

}


if(isset($_GET['deleteID']))
{
	$getEPKlist1 = mysql_query("SELECT * FROM `epk_host_info` WHERE `host_id` = '$_GET[deleteID]' ");
	$fetchResult = mysql_fetch_assoc($getEPKlist1);

	unlink($fetchResult['videoLink']);
	unlink($fetchResult['primaryPhoto']);
	unlink($fetchResult['specialPhototPath']);
	unlink($fetchResult['specialPhotothumbPath']);
	unlink($fetchResult['primaryPhotothumbPath']);
	mysql_query("DELETE FROM `epk_host_info` WHERE `epkId` = '$_GET[deleteID]' ");



	$getPhotosList = mysql_query("SELECT * FROM `epk_host_photos` WHERE `epkID` = '$_GET[deleteID]' ");
	while($rr = mysql_fetch_assoc($getPhotosList))
	{
		unlink($fetchResult['thumb']);
		unlink($fetchResult['fullpath']);
	}

	mysql_query("DELETE FROM `epk_host_photos` WHERE `epkID` = '$_GET[deleteID]' ");
}





$getEPKlist = mysql_query("SELECT * FROM `epk_host_info` WHERE `host_id` = '$userID' ");




?>
<style>
span.formw {
 float: right;
 text-align: left;
 width: 480px;
}
div.row {
 clear: both;
 padding-top: 5px
}
.display.epkAction img {
  vertical-align: middle;
}
 
.display.epkAction a {
  padding: 0 15px;
  border-right:1px solid #7c7c7c;
  color:#7c7c7c;
  text-transform:uppercase;
}
.display.epkAction a:last-child {border:0; color:#f00 !important;}
</style>

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
						<?php 
							if(isset($_SESSION['epkInfo']) && $_SESSION['epkInfo'] == 'Updated')
							{
								?>
								<div id="error" class="successmessage" style="">
									Electronic Press Kit (EPK) Information Updated.
								</div>
								<?php
								unset($_SESSION['epkInfo']);
							}
						?>

						<h3 id="title">Electronic Press Kit (EPK)</h3>
						<a style="float:left" class="learnEpk" href="https://mysittidev.com/Epk_kit.php">
									Learn More?</a>
						<div class="addEPK">
								
							</div>

						<div id="middle" style="" >
							
							<div class="autoscroll">
								<table  id="example" class="display epkAction" style="margin-top:10px; background:#fff;" >
									<thead>
										<tr style="background-color:rgb(254, 205, 7); line-height:34px">
									    	<th width="20%">EPK page Title</th>
									    	<th width="20%">Template Type</th>
									    	<th width="10%">Select Default</th>
											<th width="35%">Action</th>
										</tr>
										<a href="epkTemplate.php">Create EPK</a>

									</thead>
									<tbody>
									<?php 
										if(mysql_num_rows($getEPKlist) > 0)
										{
											while($row = mysql_fetch_assoc($getEPKlist))
											{
												if($row['template'] == '0')
												{
													$html = 'viewEPK.php';
												}
												elseif($row['template'] == '1')
												{
													$html = 'viewEPK1.php';
												}
												elseif($row['template'] == '2')
												{
													$html = 'viewEPK2.php';
												}
											?>
												<tr>
													<td>
														<?php echo $row['epkPagetitle']; ?>
													</td>
													<td>
													  <?php if($row['template'] == 0) {?>
                                                         <p>Template1</p>
													  <?php }elseif($row['template'] == 1){ ?>
                                                        <p>Template2</p>
													  <?php }elseif($row['template'] == 2){ ?>
													  	<p>Template3</p>
                                                      <?php } ?>

													</td>
													<td>
														<input <?php if($row['status'] == '1') { echo 'checked';} ?> type="radio" name="status" id="setdefaultepk_<?php echo $row['epkId'];?>" onclick="SetDefaultEpk('<?php echo $row['epkId']; ?>');" />
													</td>

													<td class="epkAction">
													    <?php if($row['template'] == 0) {?>
														<a href="<?php echo $SiteURL;?>epk.php?epkID=<?php echo $row['epkId'];?>"><img src="images/editEpk.png" alt="" /> EDIT</a>
														<?php }elseif($row['template'] == 1){ ?>

                                                        <a href="<?php echo $SiteURL;?>epk1.php?epkID=<?php echo $row['epkId'];?>"><img src="images/editEpk.png" alt="" /> EDIT</a>

														<?php }elseif($row['template'] == 2){ ?>

														<a href="<?php echo $SiteURL;?>epk2.php?epkID=<?php echo $row['epkId'];?>"><img src="images/editEpk.png" alt="" /> EDIT</a>

														<?php } ?>
                                                       

                                                        <?php  if($row['template'] == 0){ ?>
														<a href="<?php echo $SiteURL.$html;?>?Uid=<?php echo $row['epkId'];?>&host_id=<?php echo $_SESSION['user_id'];?>" target="_blank"><img src="images/viewEpk.png" alt="" /> Preview</a>
                                                        <?php }elseif($row['template'] == 1){ ?>

                                                         <a href="<?php echo $SiteURL.$html;?>?Uid=<?php echo $row['epkId'];?>&host_id=<?php echo $_SESSION['user_id'];?>" target="_blank"><img src="images/viewEpk.png" alt="" /> Preview</a> 

                                                        <?php }elseif($row['template'] == 2){ ?>

                                                        <a href="<?php echo $SiteURL.$html;?>?Uid=<?php echo $row['epkId'];?>&host_id=<?php echo $_SESSION['user_id'];?>" target="_blank"><img src="images/viewEpk.png" alt="" /> Preview</a>

                                                        <?php } ?>


														<a href="<?php echo $SiteURL;?>EPKlist.php?deleteID=<?php echo $row['epkId'];?>"><img src="images/deleteEpk.png" alt="" /> DELETE</a>
													</td>
												</tr>
									<?php 		}
										}
										else
										{
									?>		
											<tr>
												<td colspan="3">
													You have no EPK Created. 
													<?php
													sleep(25);
													header('Location: https://mysittidev.com/epkTemplate.php');
    												die();
													?>
													<!-- <a href="epk.php">Create new EPK</a> -->
												</td>
											</tr>
									<?php
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
		  			</div>
				</div>
	  		</div>
		</article>
  	</div>
</div>
<script type="text/javascript">
	function SetDefaultEpk(id)
	{
		var getvAl = $('#setdefaultepk_'+id).val();
		if(getvAl === 'on')
		{
			$.ajax({
				type: "POST",
				url: "refreshajax.php",
				data: {

					'action': "SetDefaultEpk", 
					'epkID' : id,

				},
				success: function( msg ) 
				{
					if(msg == 'ok')
					{
						alert('Selected EPK template is set as Default!');
					}
				}

			});
		}
		
	}
</script>

<?php
include('LandingPageFooter.php');

unset($_SESSION['year_Edit']);
unset($_SESSION['month_Edit']);

