<?php
include("Query.Inc.php");

$Obj = new Query($DBName);
if(!isset($_SESSION['user_id'])){
$Obj->Redirect("login.php");
}

$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if($userType=='user'){
	//$Obj->Redirect("index.php");
}

$cd_id = $_GET['cd_id'];
$hostID = $_GET['host_id'];
$cd_name = $_GET['cd_name'];
if($_GET['host_id']!="")
{

	 $tracks = mysql_query("Select * From cd_tracks INNER JOIN cds ON cds.cd_name = cd_tracks.cd_name WHERE cd_tracks.cd_id = '$cd_id' && cd_tracks.host_id = '$hostID' ORDER BY cd_tracks.id DESC ");
	
}

else {
	
	$tracks = mysql_query("Select * From cd_tracks INNER JOIN cds ON cds.cd_name = cd_tracks.cd_name WHERE cd_tracks.cd_id = '$cd_id' ORDER BY cd_tracks.id DESC");
}

$titleofpage = "Track List";

if(isset($_GET['host_id']))
{
	include('LoginHeader.php');
}
else
{
	include('HeaderHost.php');	
}

  /******************/
if(isset($_REQUEST['host_id']))
{
	$userID=$_REQUEST['id'];
}
else 
{
	$userID=$_SESSION['user_id'];	
}
?> 
<div class="clear"></div>
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
					
					<h3 id="title">Track List</h3>
					<?php if($message['success'] != ""){ 

					echo '<div id="successmessage" class="message" >'.$message['success']."</div>";
					}
					if($message['error'] != ""){ 

					echo '<div id="errormessage" class="message" >'.$message['error']."</div>";
					}
					?>
					<div id="profile_box" >

				<?php 
				$count1 = mysql_numrows($tracks);
				$class="";
				if($count1 > 9)
				{
					$class=" class='scroll_Div1'";
				}
				?>
				<form method="POST" action="" >
				  <div <?php echo $class; ?>>
      <div class="autoscroll">
					<table class='display loadmusic' id='example' style='margin-top:10px;' >
						<thead>
						<tr bgcolor='#ACD6FE'>
							<th></th>            
							<th>CD Cover</th>
							<th>Genre</th>
							<th>Release Date</th>
							<th>CD Price</th>
							
						</tr>
						</thead>
						<tbody>
						<?php $i=1;
						$count = mysql_numrows($tracks);
						if($count != 0){
						$a = 0;
								while($cdarray = mysql_fetch_array($tracks))
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
									<tr <?php echo $class;?>>
										<td>
											<?php
								if($_GET['host_id']!="")
									{
								$userID = $_GET['host_id'];
								 ?>
									 
				<audio style="display:none;" controls='' id='cdplayer<?php echo $a ;?>'>
				<source src="cd_tracks/<?php echo  $userID."/".$cdarray['cd_path'];?>" type="audio/mpeg">
				<source src="cd_tracks/<?php echo $userID."/".$cdarray['cd_path'];?>" type="audio/ogg">
				<embed height='50' width='100' src="cd_tracks/<?php echo $userID."/".$cdarray['cd_path'];?>"></audio>
				<a href='javascript:play1();' id='<?php echo $a; ?>' class='test audio'><img height="30px" src="images/new_portal/play1.png"></a>
				<a href='javascript:pause();' class="pause" id='<?php echo $a; ?>'><img height="30px" src="images/new_portal/pause1.png"></a>   
								 
								 
								<?php	}
							else
							{
								echo "<audio  style='display:none;'controls id='player$a'><source src='cd_tracks/".$userID."/".$cdarray['cd_path']."' type='audio/mpeg'><source src='cd_tracks/".$userID."/".$cdarray['cd_path']."' type='audio/ogg'><embed height='50' width='100' src='cd_tracks/".$userID."/".$cdarray['cd_path']."'></audio><a href='javascript:play1();' id='".$a."' class='test audio'><img height='30px' src='images/new_portal/play1.png'></a>
				<a href='javascript:pause();' class='pause' id='".$a."'><img height='30px' src='images/new_portal/pause1.png'></a>";

							} ?>
										</td>
										<td>
											<img src="cd_images/<?php echo $userID .'/'. $cdarray['cd_pic']; ?>" style="width: 50px; height: 50px;"/>
										</td>
									   
										<td>
											<?php echo $cdarray['cd_genre']; ?>
										</td>
										<td>
											<?php 
											if(!empty($cdarray['cd_release_date']))
											{
												$date =  $cdarray['cd_release_date'];
														$d = strtotime($date);
														echo date('M d, Y',$d);
											}
											?>
										</td>
										<td>
											<?php echo "$".$cdarray['cd_price']; ?>
										</td>
										
									</tr>
									
									<?php
							$a++;		$i++;
								}
						
						}
						else
						{
							?>
							<tr class="odd">
										<td colspan="5">
											No CD Tracks records yet !
										</td>
							</tr>
						<?php 	
							
						}
						?>
						</tbody>
					</table>
					</div>	</div>
				   
						  </div>					
					
					</div>
				</div>
			</div>
		</article>
	</div>
</div>

<script language="javascript">	
$(document).ready(function(){

$('.test').click(function(){
	var id=$(this).attr('id');
$(this).addClass('pause');
  
var audio = document.getElementById('cdplayer'+id);

play1(audio);

});

$('.pause').click(function(){
	
$('.test').removeClass('pause');
var id=$(this).attr('id');

var audio = document.getElementById('cdplayer'+id);
pause(audio);

	});

});
//var audio = document.getElementById('player1');

function play1(audio){

	audio.currentTime = 0;
	audio.play();
	int = setInterval(function() {       
		if (audio.currentTime > 20) {
			audio.pause();
		
			clearInterval(int);
		}
	}, 20);
}    
	
function pause(audio){
	audio.pause();
}
</script>
<?php include('Footer.php'); ?>