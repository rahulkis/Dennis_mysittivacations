<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($userID)){
	$Obj->Redirect("login.php");
}
$_SESSION['host_id'] = $_GET['host_id'];
$host_id = $_GET['host_id'];
$userID=$_SESSION['user_id'];

$para="";
if(isset($_REQUEST['msg']))
{
	$para=$_REQUEST['msg'];
}

if($para!="");
{
	if($para=="success")
	{
		$message="Profile Updated.";
	}
	if($para=="imagefail")
	{
		$message="Invalid Image.";
	}
	if($para=="update")
	{
		$message="Coupon Updated Sucessfully";
	}
}
if(isset($_REQUEST['id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}

$titleofpage=" Music & CDs";
include('LoginHeader.php');

?>
<script type="text/javascript">
$(document).ready(function(){
    $('object').css('width', '300px');
});

function makelike(action,video_id,who_like_id)
{
 $.get('video-like_unlike.php?action='+action+'&video_id='+video_id+'&who_like_id='+who_like_id, function(data) {
$('#vid_'+video_id).html(data);

});
}
</script>
<style>
.anchrcolor a, .anchora{
color:#E05B49;
}
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php include('host_left_panel.php') ?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content v2_musicccd">
				<?php 
					$checkpagestatus = @mysql_query("SELECT * FROM `host_functions_setting` WHERE `host_id` = '".$_GET['host_id']."' ");
					$respagestatus = @mysql_fetch_array($checkpagestatus);
					if($respagestatus['uploads'] != 'Disable with message')
					{

							?>
  						<h3 id="title">Music and CDs</h3>
						<?php 
								$myquery = mysql_query("SELECT * FROM music where host_id = $host_id ORDER BY trackname ASC");
								$num = @mysql_num_rows($myquery);
									if( $num > 10) 
									{

										$classes = "scroll_Div1 ";
									}
									else
									{
										$classes = "scroll_Div1no ";
									}
										?>


						<div class="<?php echo $classes; ?>">
      <div class="autoscroll">
											<table class='displays loadmusic anchrcolor' id='example' style='margin-top:10px;' >
						        <thead>
						        <tr bgcolor='#ACD6FE' style=" padding: 5px 10px; text-align: center;">
						            <th></th>

						            <th>Track Name</th>
						            <th>Artist</th>
						            <th>Label</th>
						            <th>Genre</th>
						            <th>Release Date</th>
						            <th>Price</th>
							     </tr>
						        </thead>
						        <tbody>

						<?php
							if($num > 0)
							{
								$i=1;
						        $a= 0;        
						        while($res = mysql_fetch_array($myquery))
						        {
						               
						            if($i%2 == '0')
									{
										$class = " class='even' ";
									}
									else
									{
										$class = " class='odd' ";
									}

							?>
						                    
						                <tr>    
								 <form method="POST" action="cart.php">
								  <input type="hidden" name="product_id" value="<?php echo $res['id'];?>">
						          <input type="hidden" name="host_id" value="<?php echo $_GET['host_id'];?>">      
								  <input type="hidden" name="price_cart" value="<?php echo $res['price'];?>"> 
								  <input type="hidden" name="product_type" value="0"> 
							<input type="hidden" name="product_qty" value="1"> 
							<input type="hidden" name="music_type" value="music">
						            <td>
									<audio style="display:none;" controls id="player<?php echo $a ;?>">
									<source src="<?php echo $res['musicpath'];?>" type="audio/mpeg">
									<source src="<?php echo $res['musicpath'];?>" type="audio/ogg">
									<embed height="50" width="100" src="<?php echo $res['musicpath'];?>"></embed>
									</audio>
                                    <div class="plsypause">
									<a href='javascript:play1();' id="<?php echo $a;?>" class="anchora test audio"><img src="images/new_portal/play1.png" alt="" /></a>
									<a href='javascript:pause();' class='pause anchora' id="<?php echo $a;?>"><img src="images/new_portal/pause1.png" alt="" /></a>
                                    </div>
						               </td>
						          <td><?php echo $res['trackname']; ?></td>
						            <td> <?php echo $res['artist']; ?></td>
								<td><?php echo $res['label']; ?></td>
								 <td><?php echo $res['genre']; ?></td>
								<td><?php
									    $date = strtotime($res['releasedate']);
									      echo date('M d, Y',$date);
									    
									    //echo $res['releasedate']; ?>
								</td>
								<td>	
								<span class="musicprice"> <?  $data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$_GET['host_id']);
						                                                    if(!$data_upgrade_needed){?>
						                                                    <?php echo "$".$res['price']; ?> </span>
								                  <input type='image' src="images/cart.png"/>
								                   	<?}else{?>
								                   	 <?php echo "$".$res['price']; ?> 
								                   		<!--<input style="background:black;" type='button' onclick="upgradePlan('<? echo $data_upgrade['plantype']; ?>')" class="button" value="<?php echo "$".$res['price']; ?>" />-->
								                   	<? } ?>
								
								
								
								       </td>
						                  
						                    </form>
						                    </tr>
						                    
						                    <?php 
						            $a++;    
						        }
						    }
						    else
						    {
						    	echo "<tr><td align='center' style='text-align:center !important' colspan='7'>No Records Found.</td></tr>";
						    }
						        
						        
						        ?>
						        </tbody>        
						        </table>
						    </div>
          </div>
						<?php

						//$results = "Select * From cds INNER JOIN cd_tracks ON cds.cd_name = cd_tracks.cd_name WHERE cd_tracks.uid = '". $userID."'";
						 $results = "Select * From cd_tracks INNER JOIN cds ON cds.cd_name = cd_tracks.cd_name WHERE cd_tracks.host_id = $host_id GROUP BY cds.cd_name ORDER BY cd_tracks.id DESC  ";/*where cd_tracks.host_id = $userID*/

						$cdtracksdata = mysql_query($results);
						if(@mysql_num_rows($cdtracksdata)>0) {$a = 0 ;
						echo '<span style="border: 2px solid; float: left; width: 100%; margin-top: 30px;"></span>';
						echo "<div class='cdform'>";
						while($cdarray = mysql_fetch_array($cdtracksdata))
						{
						$date = strtotime($res['cd_release_date']);
									      $sort = date('M d, Y',$date);
						echo ' <form method="POST" action="cart.php">';
						//echo "<input type='hidden' value='$cdarray[id]' name='cd_data'/>";
						?> 

						<input type="hidden" name="product_id" value="<?php echo $cdarray['cd_id'];?>">
						 <input type="hidden" name="product_id" value="<?php echo $cdarray['id'];?>">
						 <input type="hidden" name="host_id" value="<?php echo $_GET['host_id'];?>">    
						<input type="hidden" name="price_cart" value="<?php echo $cdarray['cd_price'];?>"> 
						<input type="hidden" name="product_type" value="1"> 
						<input type="hidden" name="product_qty" value="1"> 
						  <?
						echo "<div class='cds'>"."<span class='gray'><dd class='cdname'>".$cdarray['cd_name']."</dd>";
						echo "<dd class='cddata'>BY : ".$_SESSION['username']." ".$sort."</dd></span>";
						echo "<span class='cddesc'>".$cdarray[cd_description]."</span>";
						?>

						<audio style="display:none;"  controls='' id='cdplayer<?php echo $a ;?>'>
						<source src="cd_tracks/<?php echo  $host_id."/".$cdarray['cd_path'];?>" type="audio/mpeg">
						<source src="cd_tracks/<?php echo $host_id."/".$cdarray['cd_path'];?>" type="audio/ogg">
						<embed height='50' width='100' src="cd_tracks/<?php echo $host_id."/".$cdarray['cd_path'];?>"></audio>
                        <div class="playpause">
						<a href='javascript:play1();' class='anchora test audio'  id='<?php echo $a; ?>'><img src="images/new_portal/play.png" alt="" /></a>
						<a href='javascript:pause();' class="pause anchora" id="<?php echo $a;?>"><img src="images/new_portal/pause.png" alt="" /></a>
                        </div>
						<?  $data_upgrade_needed=chk_upgrade_needed_shopping($data_upgrade['plantype'],"18",$_GET['host_id']);
						                                                    if(!$data_upgrade_needed){?>
						<?php 
						echo "<dd class='price'>$.$cdarray[cd_price]<input type='image' src='images/cart2.png'/></dd></span>";
						}else{
							echo "<dd class='price'>$.$cdarray[cd_price]</dd></span>";
						}
							
						if($_GET['host_id']!= "")
						      {
						echo "<dd class='viewtracks'><a href='cdtracks.php?cd_id=".$cdarray['id']."&cd_name=".$cdarray['cd_name']."&host_id=".$host_id."'>View Tracks</a></dd></div></form>";
						      }
						else {echo "<dd class='viewtracks'><a href='cdtracks.php?cd_id=".$cdarray['id']."&cd_name=".$cdarray['cd_name']."'>View Tracks</a></dd></div></form>";}      
						$a++;
						}
						echo "</div>";
						} else { echo '<div class="cdform"><p class="musiccdp">No CDs Yet !</p></div>';}
						
						if(isset($_GET['host_id']))
						{ 
					?>		
                    <div class="clear"></div>
                    <div style="float:left;">
								<a href="host_profile.php?host_id=<?php echo $_GET['host_id']; ?>" class="button backmargn">Back </a>
							</div>
					<?php 	} ?>
			<?php  }
				else
				{
					$pagestatus = "0";	
					echo "<div class='nostoreview' >";
					if($respagestatus['uploads'] == "Disable with message")
					{
						echo "<h1 id='title' style='text-align: center;'>".$respagestatus['uploadsmessage']."</h1>";
					}
					if($respagestatus['uploads'] == "Disable without message")
					{
						
					}

					echo "</div>";
				}
				?>




  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>


<script language="javascript">
function playvideo(id)
{
jwplayer('a'+id).stop();
$('#ve_'+id).click();
 
}
function  deletevideo(id)
{
var r=confirm("Are you sure you want delete this video");
if (r==true)
  {
    $.get('delete-video.php?video_id='+id, function(data) {
	 window.location='home_club.php';
	});
  }

 }
 
 function deletephoto(id)
 {
   var r=confirm("Are you sure you want delete this Photo");
if (r==true)
  {
    $.get('delete-video.php?type=img&image_id='+id, function(data)
	{
	 window.location='home_club.php';
	});
  }
 
 }
</script>
<?php include('Footer.php');?>