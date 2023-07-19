<?php
include("Query.Inc.php");
$Obj = new Query($DBName);
$userID=$_SESSION['user_id'];
$userType= $_SESSION['user_type'];
if(!isset($_SESSION['user_id']))
{
	$Obj->Redirect("login.php");
}


if(isset($_GET['deleteFighter']))
{
	$fighterID = $_GET['deleteFighter'];
	$update="DELETE FROM friends WHERE friend_id='$fighterID'  AND friend_type = 'club' AND user_type= '$_SESSION[user_type]' AND  user_id = '".$_SESSION['user_id']."' ";
	@mysql_query($update);

	@mysql_query("DELETE FROM friends WHERE user_id='$fighterID'  AND friend_type = '$_SESSION[user_type]' AND user_type= 'club' AND friend_id = '".$_SESSION['user_id']."' ");

	//$update="update friends set status='block' where  user_id='".$friends['friend_id']."' AND friend_id='".$friends['user_id']."'";
	//@mysql_query($update);
	@mysql_query("DELETE FROM user_to_content WHERE user_id ='$fighterID' AND owner_id = '".$_SESSION['user_id']."'  ");
	@mysql_query("DELETE FROM user_to_content WHERE owner_id ='$fighterID' AND user_id = '".$_SESSION['user_id']."'  ");

	$Obj->Redirect('fightersList.php?msg=deleted');
}


$titleofpage="Fighters List";	

include('LoginHeader.php');

?>
<script type="text/javascript">

function requestFriend(id, from, to)
{
	$.get('send-request.php?friend_id='+id+'&from_user_type='+from+'&to_user_type='+to+'&action=fighter', function(data) {
		$('#request_'+id).html("Requested");
		//window.top.location.reload();
	});
}

function confrmDelete(url)
{
	if(confirm('Are you sure you want to delete this fighter?'))
	{
		window.top.location = url;
	}
}


function test()
{
	$.blockUI({ css: {
		border: 'none',
		padding: '15px',
		backgroundColor: '#fecd07',
		'-webkit-border-radius': '10px',
		'-moz-border-radius': '10px',
		opacity: .8,
		color: '#000'
	},
	message: '<h1>Loading Results</h1>'
	});
	setTimeout(function() {
		// Do something after 5 seconds
		$('#searchFighters').submit();
	}, 1000);	
}


</script>
<style type="text/css">

 
.instructorImage {
	float: left;
	width: 100%;
}
.instructorImage > a {
  width: 100%;
  float: left;
  text-align: center;
  position: relative;
  min-height: 130px;
  max-height: 130px;
  overflow: hidden;
}
.instructorImage a img {

	max-width:100%;
	position:absolute;
	left:0;
	right:0;
	top:0;
	bottom:0;
	margin:auto;
}
.instructorName {
	float: left;
	margin: 10px 0;
	/*text-align: center;*/
	width: 100%;
	color: #fecd07;
}
.instructorName > a {
  color: #000;
}
.fightersearch {
	float: left;
	width: 100%;
}
.fightersearch > form {
	float: left;
	max-width: 100%;
}
span.searchButton {
	float: left;
	margin: 0 10px;
	width: 20% !important;
}
.searchfightersList {
	float: left;
	width: 100%;
}
.search_whistling {width:47% !important; margin:10px 3% 10px 0 !important; background:#fff; padding:5px; box-sizing:border-box; float:left;}
.filter_thumb{float: left;
width: 30%;}
.filter_thumb img {max-width:100%;}
.filter_info {
  float: right;
  margin-left: 2%;
  width: 66%;
}
.c_name {
  float: left;
  font-size: 15px;
  margin-bottom: 10px;
  width: 100%;
}
.c_email {
  float: left;
  font-size: 13px;
  margin-bottom: 10px;
  width: 100%;
}
.txt_box.ac_input {
  height: 25px;
}

.request_btn a{border:1px solid #000; color:#000 !important; margin-top:10px;}
</style>
<div class="clear"></div>
<div class="v2_container">
	<div class="v2_inner_main">
	<!-- SIDEBAR CODE  -->
	<?php 
 	if(isset($_GET['host_id']))
	{
		include('host_left_panel.php');
	}
	else
	{
		include('club-right-panel.php');
	}
 	
	?>
	<!-- END SIDEBAR CODE -->
		<article class="forum_content v2_contentbar">
			<div class="v2_rotate_neg">
				<div class="v2_rotate_pos">
					<div class="v2_inner_main_content">
  						<?php 
  						if($_GET['msg'] == "deleted")
						{ 
							echo '<div style="display:block;" id="successmessage" class="message" >Fighter Deleted Successfully.</div>';
						}
						if($message['error'] != "")
						{ 
							echo '<div style="display:block;" id="errormessage" class="message" ></div>';
						} 

			if(!isset($_GET['host_id']))
			{


				?>

				<div class="fightersearch">
					<h3 id="title">Search</h3>
					<form action="" method="POST" name="fightersearch" id="searchFighters">
						<div class="row">
 							<span class="label">
 								<label>Fighter's Name: </label>
 							</span>
 							<span class="formw1" style="float:left">
 								<input type="text" name="fighter_name" id="fighterName" class="txt_box" />
 							</span>
 							<span class="searchButton">
								<input type="submit" class="button" name="searchFighter" value="Search"  />
 							</span>
 						</div>
 						<link rel="stylesheet" href="css/jukebox.css" />
						<link rel="stylesheet" href="autocomplete/jquery.ajaxcomplete.css" />
						<!-- <script type="text/javascript" src="autocomplete/jquery.js"></script> -->
						<script src="autocomplete/jquery.ajaxcomplete.js"></script>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#fighterName').autocomplete("refreshajax.php?action=clubs_search_fighters");
						});
						</script>
	
						
 						
					</form>		
				</div>
			<?php 
			} // END FOR SESSION CHECK
				if(!empty($_POST['fighter_name']))
				{
			?>
					<div class="searchfightersList">
						<h3 id="title">Search Results</h3>
					<?php 
						
							$fighterName = mysql_real_escape_string(trim($_POST['fighter_name']));
							$getFighterinfo = mysql_query("SELECT * FROM `clubs` WHERE `club_name` LIKE '%$fighterName%' ");
							while($fetchFighterinfo = mysql_fetch_assoc($getFighterinfo) )
							{
								$getFriendinfo = mysql_query("SELECT * FROM `friends` WHERE `user_id`= '$fetchFighterinfo[id]' AND `friend_id` = '$_SESSION[user_id]' AND `user_type` = 'club' AND `friend_type` = 'club' ");
								$getFriendinfo2 = mysql_query("SELECT * FROM `friends` WHERE `friend_id`= '$fetchFighterinfo[id]' AND `user_id` = '$_SESSION[user_id]' AND `user_type` = 'club' AND `friend_type` = 'club' ");
							//	echo mysql_num_rows($getFriendinfo2);
							//	echo mysql_num_rows($getFriendinfo);
					?>
								<div style="overflow:hidden; position:relative;" class="search_whistling">
									<div style="" class="filter_thumb">
										<div style=""> <!--class="profileicon"-->
											<a href="<?php echo $fetchFighterinfo['id'];?>">                              
												<img height="100" width="100" style="border:1px solid #333;" src="<?php echo $fetchFighterinfo['image_nm'];?>" />
											</a>
										</div>
									</div>
									<div style="" class="filter_info">
										<div style="" class="">
											<div class="c_name"><?php echo $fetchFighterinfo['club_name']; ?>&nbsp;</div>
											<div class="c_email"><?php echo $fetchFighterinfo['club_email']; ?></div>                           
										</div>
										<span class="request_btn" id="request_<?php echo $fetchFighterinfo['id'];?>">
										<?php 
											if(mysql_num_rows($getFriendinfo2) < 1 && mysql_num_rows($getFriendinfo) < 1)
											{
										?>
												<a style="color:#FFF !important;" class="button" onclick="requestFriend('<?php echo $fetchFighterinfo['id'];?>', '<?php echo $_SESSION['user_type'];?>' , 'club');" href="javascript:void(0);">Send Peep Request </a>
										<?php 	}
											else
											{
												echo "<a href='javascript:void(0);' class='button'>Already Added.</a>";
											}	
										?>
										</span>
									</div>  
								</div>
					<?php 		}	?>
					</div>
			<?php 	}
if(isset($_GET['host_id']))
{
	$UserID = $_GET['host_id'];
}
else
{
	$UserID = $_SESSION['user_id'];
}
				$sql4="SELECT distinct(fs.user_id),fs.friend_type, fs.user_type,fs.status as freindstatus,fs.chat,fs.id as f_id from friends as fs
					WHERE fs.friend_id='$UserID' 
					AND fs.user_id != 1 
					AND fs.status IN ('active','pending')
					GROUP BY user_id ORDER BY f_id ASC";
			 	$sql6 = mysql_query($sql4);
				$num = mysql_num_rows($sql6);
				if($num > 0)
				{	
			?>
					<div class="fightersList">
						<h3 id="title">Fighters List</h3>
						<?php 
							while($row = mysql_fetch_assoc($sql6))
							{
								$getFighterINFO = mysql_query("SELECT * FROM `clubs` WHERE `id` = '$row[user_id]' ");
								$fetchinstructors = mysql_fetch_assoc($getFighterINFO);
								if($fetchinstructors['type_of_club'] == '106')
								{
								?>
									<div class="instructors_box">
	 									<div class="instructorImage">
	 										<a href="javascript:void(0);" onclick="window.open('hostprofileInfo.php?host_id=<?php echo $fetchinstructors['id']; ?>','','width=700,height=700,resizable=true,left=300,top=0');">
	 											<img src="<?php echo $fetchinstructors['image_nm'] ;?>" alt="" />
	 										</a>
	 									</div>
	 									<div class="instructorName">
	 										<a href="fighter_profile.php?host_id=<?php echo $fetchinstructors['id']; ?>"><?php echo $fetchinstructors['club_name']; ?></a>
 											<div class="down_del">
										<?php 
										if(!isset($_GET['host_id']))
										{
 											if($row['freindstatus'] == "pending")
 											{
 												echo  "Request Pending";
 											}
 											else
 											{
 											?>
                               										<a href="javascript:void(0);" onclick="confrmDelete('?deleteFighter=<?php echo $fetchinstructors['id']; ?>');" title="Delete" class="del_stream_vid"> </a> 
                               								<?php 	
                               									}
                   									}
                   									?>
                               									</div>
	 									</div>
	 								</div>
								<?php 
								}
							}
						?>
					</div>
			<?php 	}	?>
  					</div>
  				</div>
			</div>
			<div class="equalizer"></div>
		</article>
	</div>
	<div class="clear"></div>
</div>
<?php include('Footer.php');?>